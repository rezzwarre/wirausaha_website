<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    protected function getOrCreateCart(): Cart
    {
        return Cart::firstOrCreate(['user_id' => Auth::id()]);
    }

    public function index()
    {
        $cart = $this->getOrCreateCart();
        $cart->load(['items.product.category']);

        $totalItems = $cart->total_items;
        $totalPrice = $cart->total_price;

        return view('customer.cart', compact('cart', 'totalItems', 'totalPrice'));
    }

    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'nullable|integer|min:1',
        ]);

        $product = Product::findOrFail($request->product_id);

        if (!$product->is_active) {
            return back()->with('error', 'Produk ini sedang tidak tersedia.');
        }

        $quantity = (int) $request->input('quantity', 1);

        if ($product->stock < $quantity) {
            return back()->with('error', 'Stok produk tidak mencukupi (Tersisa: ' . $product->stock . ').');
        }

        $cart = $this->getOrCreateCart();

        $cartItem = CartItem::where('cart_id', $cart->id)
            ->where('product_id', $product->id)
            ->first();

        if ($cartItem) {
            $newQuantity = $cartItem->quantity + $quantity;
            if ($product->stock < $newQuantity) {
                return back()->with('error', 'Jumlah total melebihi stok yang tersedia (Tersisa: ' . $product->stock . ').');
            }
            $cartItem->update(['quantity' => $newQuantity]);
        } else {
            CartItem::create([
                'cart_id' => $cart->id,
                'product_id' => $product->id,
                'quantity' => $quantity,
            ]);
        }

        return redirect()->route('cart.index')->with('success', 'Produk berhasil ditambahkan ke keranjang belanja!');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $cart = $this->getOrCreateCart();
        $cartItem = CartItem::where('cart_id', $cart->id)->where('id', $id)->firstOrFail();

        if ($cartItem->product->stock < $request->quantity) {
            return back()->with('error', 'Jumlah melebihi stok yang tersedia (Tersisa: ' . $cartItem->product->stock . ').');
        }

        $cartItem->update(['quantity' => $request->quantity]);

        return back()->with('success', 'Jumlah produk berhasil diperbarui.');
    }

    public function remove($id)
    {
        $cart = $this->getOrCreateCart();
        $cartItem = CartItem::where('cart_id', $cart->id)->where('id', $id)->firstOrFail();
        $cartItem->delete();

        return back()->with('success', 'Produk berhasil dihapus dari keranjang.');
    }
}
