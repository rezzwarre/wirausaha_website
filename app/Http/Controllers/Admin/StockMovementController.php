<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\StockMovement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class StockMovementController extends Controller
{
    public function index(Request $request)
    {
        $products = Product::all();
        $query = StockMovement::with(['product', 'order', 'creator'])->latest();

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        if ($request->filled('product_id')) {
            $query->where('product_id', $request->product_id);
        }

        $movements = $query->paginate(15)->withQueryString();

        return view('admin.stock_movements.index', compact('movements', 'products'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'type' => 'required|in:in,out',
            'quantity' => 'required|integer|min:1',
            'note' => 'required|string|max:255',
        ]);

        $product = Product::findOrFail($validated['product_id']);

        if ($validated['type'] === 'out' && $product->stock < $validated['quantity']) {
            return back()->with('error', "Stok produk tidak mencukupi untuk dikeluarkan (Stok saat ini: {$product->stock}).");
        }

        DB::transaction(function () use ($validated, $product) {
            if ($validated['type'] === 'in') {
                $product->increment('stock', $validated['quantity']);
            } else {
                $product->decrement('stock', $validated['quantity']);
            }

            StockMovement::create([
                'product_id' => $product->id,
                'order_id' => null,
                'created_by' => Auth::id(),
                'type' => $validated['type'],
                'quantity' => $validated['quantity'],
                'note' => $validated['note'],
            ]);
        });

        $actionText = $validated['type'] === 'in' ? 'Stok masuk berhasil dicatat dan stok produk bertambah.' : 'Stok keluar berhasil dicatat dan stok produk berkurang.';

        return redirect()->route('admin.stock-movements.index')->with('success', $actionText);
    }
}
