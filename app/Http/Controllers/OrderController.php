<?php

namespace App\Http\Controllers;

use App\Models\BankAccount;
use App\Models\Order;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with(['items.product', 'payment'])
            ->where('user_id', Auth::id())
            ->latest()
            ->paginate(10);

        return view('customer.orders.index', compact('orders'));
    }

    public function show($id)
    {
        $order = Order::with(['items.product.category', 'payment.bankAccount', 'user'])
            ->where('user_id', Auth::id())
            ->where('id', $id)
            ->firstOrFail();

        $bankAccounts = BankAccount::where('is_active', true)->get();

        // Contact phone for WhatsApp
        $adminPhone = '6281234567890';
        $waMessage = urlencode("Halo Admin Wirausahagoo, saya ingin konfirmasi pesanan dengan Kode: {$order->order_code} senilai {$order->formatted_total}.");
        $waUrl = "https://wa.me/{$adminPhone}?text={$waMessage}";

        return view('customer.orders.show', compact('order', 'bankAccounts', 'waUrl'));
    }

    public function uploadPayment(Request $request, $id)
    {
        $order = Order::where('user_id', Auth::id())->where('id', $id)->firstOrFail();

        if (in_array($order->status, ['confirmed', 'cancelled'])) {
            return back()->with('error', 'Status pesanan tidak memungkinkan untuk upload pembayaran baru.');
        }

        $request->validate([
            'bank_account_id' => 'required|exists:bank_accounts,id',
            'proof_image' => 'required|image|mimes:jpeg,png,jpg,webp|max:3072',
        ]);

        $file = $request->file('proof_image');
        $filename = 'payment_' . time() . '_' . Str::random(6) . '.' . $file->getClientOriginalExtension();
        $file->move(public_path('uploads/payments'), $filename);

        // Update or create payment
        $payment = Payment::where('order_id', $order->id)->first();
        if ($payment) {
            $payment->update([
                'bank_account_id' => $request->bank_account_id,
                'proof_image' => 'uploads/payments/' . $filename,
                'status' => 'pending',
                'admin_note' => null,
            ]);
        } else {
            Payment::create([
                'order_id' => $order->id,
                'bank_account_id' => $request->bank_account_id,
                'proof_image' => 'uploads/payments/' . $filename,
                'status' => 'pending',
            ]);
        }

        $order->update(['status' => 'waiting_confirmation']);

        return back()->with('success', 'Bukti pembayaran berhasil diupload! Menunggu verifikasi dari admin.');
    }
}
