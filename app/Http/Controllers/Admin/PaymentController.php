<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Payment;
use App\Models\StockMovement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PaymentController extends Controller
{
    public function index(Request $request)
    {
        $query = Payment::with(['order.user', 'bankAccount', 'verifier'])->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $payments = $query->paginate(10)->withQueryString();

        return view('admin.payments.index', compact('payments'));
    }

    public function show($id)
    {
        $payment = Payment::with(['order.user', 'order.items.product', 'bankAccount', 'verifier'])->findOrFail($id);
        return view('admin.payments.show', compact('payment'));
    }

    public function verify(Request $request, $id)
    {
        $payment = Payment::with('order.items.product')->findOrFail($id);
        $order = $payment->order;

        $request->validate([
            'status' => 'required|in:approved,rejected',
            'admin_note' => 'nullable|string|max:500',
        ]);

        return DB::transaction(function () use ($request, $payment, $order) {
            $isApproved = ($request->status === 'approved');

            $payment->update([
                'status' => $request->status,
                'admin_note' => $request->admin_note,
                'verified_by' => Auth::id(),
                'verified_at' => now(),
            ]);

            if ($isApproved) {
                // Update status pesanan jadi confirmed
                $order->update(['status' => 'confirmed']);

                // Memicu perubahan stok barang (Stock Movement OUT) jika belum pernah dicatat untuk order ini
                $existingMovement = StockMovement::where('order_id', $order->id)->where('type', 'out')->exists();

                if (!$existingMovement) {
                    foreach ($order->items as $item) {
                        $product = $item->product;
                        if ($product) {
                            // Kurangi stok barang
                            $product->decrement('stock', $item->quantity);

                            // Catat ke riwayat stock_movements
                            StockMovement::create([
                                'product_id' => $product->id,
                                'order_id' => $order->id,
                                'created_by' => Auth::id(),
                                'type' => 'out',
                                'quantity' => $item->quantity,
                                'note' => "Pengurangan stok otomatis setelah konfirmasi pembayaran pesanan {$order->order_code}",
                            ]);
                        }
                    }
                }

                $msg = "Bukti pembayaran pesanan {$order->order_code} berhasil disetujui, status pesanan telah Dikonfirmasi dan stok produk berhasil dikurangi.";
            } else {
                // Jika ditolak
                $order->update(['status' => 'rejected']);
                $msg = "Bukti pembayaran pesanan {$order->order_code} telah ditolak. Catatan admin telah disimpan.";
            }

            return redirect()->route('admin.payments.show', $payment->id)->with('success', $msg);
        });
    }
}
