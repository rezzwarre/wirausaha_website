<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::withCount(['products' => function ($query) {
            $query->where('is_active', true);
        }])->get();

        $query = Product::with('category')->where('is_active', true);

        // Search by keyword
        if ($request->filled('q')) {
            $keyword = $request->input('q');
            $query->where(function ($q) use ($keyword) {
                $q->where('name', 'like', "%{$keyword}%")
                  ->orWhere('description', 'like', "%{$keyword}%");
            });
        }

        // Filter by category slug
        if ($request->filled('category')) {
            $query->whereHas('category', function ($q) use ($request) {
                $q->where('slug', $request->input('category'));
            });
        }

        $products = $query->latest()->paginate(12)->withQueryString();

        // Featured pencil pouches for highlighting QR code product context
        $pouchProducts = Product::whereHas('category', function ($q) {
            $q->where('slug', 'pouch-pensil');
        })->where('is_active', true)->take(4)->get();

        return view('customer.home', compact('categories', 'products', 'pouchProducts'));
    }

    public function show($slug)
    {
        $product = Product::with('category')->where('slug', $slug)->firstOrFail();
        
        $relatedProducts = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->where('is_active', true)
            ->take(4)
            ->get();

        return view('customer.product_detail', compact('product', 'relatedProducts'));
    }
}
