<?php

namespace App\Http\Controllers;

use App\Models\BankAccount;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    public function index()
    {
        $cart = Cart::with(['items.product'])->where('user_id', Auth::id())->first();

        if (!$cart || $cart->items->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Keranjang Anda masih kosong. Silakan pilih produk terlebih dahulu.');
        }

        // Validate stock before checkout
        foreach ($cart->items as $item) {
            if ($item->quantity > $item->product->stock) {
                return redirect()->route('cart.index')->with(
                    'error',
                    "Stok untuk produk '{$item->product->name}' tidak mencukupi (Tersisa: {$item->product->stock}). Silakan sesuaikan jumlah pesanan."
                );
            }
        }

        $bankAccounts = BankAccount::where('is_active', true)->get();
        $user = Auth::user();

        return view('customer.checkout', compact('cart', 'bankAccounts', 'user'));
    }

    public function process(Request $request)
    {
        $request->validate([
            'shipping_address' => 'required|string',
            'bank_account_id' => 'required|exists:bank_accounts,id',
            'proof_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:3072',
        ]);

        $cart = Cart::with(['items.product'])->where('user_id', Auth::id())->first();

        if (!$cart || $cart->items->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Keranjang belanja kosong.');
        }

        return DB::transaction(function () use ($request, $cart) {
            $totalPrice = 0;

            // Check stock again in transaction
            foreach ($cart->items as $item) {
                if ($item->quantity > $item->product->stock) {
                    throw new \Exception("Stok untuk produk '{$item->product->name}' tidak mencukupi.");
                }
                $totalPrice += ($item->quantity * $item->product->price);
            }

            $hasProof = $request->hasFile('proof_image');
            $orderStatus = $hasProof ? 'waiting_confirmation' : 'pending';

            $order = Order::create([
                'user_id' => Auth::id(),
                'order_code' => 'ORD-' . strtoupper(Str::random(8)),
                'total_price' => $totalPrice,
                'shipping_address' => $request->shipping_address,
                'status' => $orderStatus,
            ]);

            foreach ($cart->items as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'price' => $item->product->price,
                    'quantity' => $item->quantity,
                    'subtotal' => $item->quantity * $item->product->price,
                ]);
            }

            // If proof image was uploaded during checkout
            if ($hasProof) {
                $file = $request->file('proof_image');
                $filename = 'payment_' . time() . '_' . Str::random(6) . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('uploads/payments'), $filename);

                Payment::create([
                    'order_id' => $order->id,
                    'bank_account_id' => $request->bank_account_id,
                    'proof_image' => 'uploads/payments/' . $filename,
                    'status' => 'pending',
                ]);
            }

            // Clear cart
            $cart->items()->delete();

            $message = $hasProof
                ? 'Pesanan berhasil dibuat dan bukti pembayaran telah diupload! Menunggu konfirmasi admin.'
                : 'Pesanan berhasil dibuat! Silakan lakukan transfer dan upload bukti pembayaran.';

            return redirect()->route('orders.show', $order->id)->with('success', $message);
        });
    }
}
