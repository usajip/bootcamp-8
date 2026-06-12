<?php

namespace App\Http\Controllers;

use App\Models\ProductCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // ORM 
        $categories = ProductCategory::withCount([
            'products', // products_count
            'products as total_stock' => function($query) {
                $query->select(DB::raw("SUM(stock)"));
            },
            'products as total_value' => function($query) {
                $query->select(DB::raw("SUM(price * stock)"));
            }
        ])
        ->when($request->input('search'), function ($query, $search) {
            return $query->where('name', 'like', "%{$search}%");
        })
        ->when($request->input('sort'), function ($query, $sort) {
            switch ($sort) {
                case 'products_count_desc':
                    $query->orderBy('products_count', 'desc');
                    break;
                case 'products_count_asc':
                    $query->orderBy('products_count', 'asc');
                    break;
                case 'total_stock_desc':
                    $query->orderBy('total_stock', 'desc');
                    break;
                case 'total_stock_asc':
                    $query->orderBy('total_stock', 'asc');
                    break;
                case 'total_value_desc':
                    $query->orderBy('total_value', 'desc');
                    break;
                case 'total_value_asc':
                    $query->orderBy('total_value', 'asc');
                    break;
            };
        })
        ->paginate(5);

        return view('dashboards.product_categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
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
    public function show(ProductCategory $productCategory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ProductCategory $productCategory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ProductCategory $productCategory)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProductCategory $productCategory)
    {
        //
    }
}
