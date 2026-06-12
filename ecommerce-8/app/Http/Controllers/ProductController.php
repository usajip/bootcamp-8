<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $sort = $request->input('sort');
        $products = Product::with('category')
            ->withCount(['orderItems' => function($query) {
                $query->whereHas('order', function($query) {
                    $query->where('status', 'completed');
                });
            }])
            ->when($search, function ($query, $search) {
                return $query->where('name', 'like', "%{$search}%")
                ->orWhere('description', 'like', "%{$search}%")
                ->orWhereHas('category', function ($query) use ($search) {
                    $query->where('name', 'like', "%{$search}%");
                });
            })
            ->when($sort, function ($query, $sort) {
                switch ($sort) {
                    case 'asc':
                        $query->orderBy('price', 'asc');
                        break;
                    case 'desc':
                        $query->orderBy('price', 'desc');
                        break;
                    case 'best_seller':
                        $query->orderBy('order_items_count', 'desc');
                        break;
                    case 'stock_low':
                        $query->orderBy('stock', 'asc');
                        break;
                    case 'stock_high':
                        $query->orderBy('stock', 'desc');
                        break;
                };
            })
            ->paginate(5);
        return view('dashboards.products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = ProductCategory::select('id', 'name')->get();
        return view('dashboards.products.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $slug)
    {
        $product = Product::with('category')
                        ->where('slug', $slug)
                        ->firstOrFail();
        $related_products = Product::where('product_category_id', $product->product_category_id)
            ->where('id', '!=', $product->id)
            ->take(4)
            ->get();
        return view('product.show', compact('product', 'related_products'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        $categories = ProductCategory::select('id', 'name')->get();
        return view('dashboards.products.edit', compact('product', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        //
    }
}
