<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
    public function show(int $id)
    {
        $product = [
            'id' => $id,
            'title' => "Product $id",
            'description' => "Description for product $id",
            'image' => 'example.jpeg',
            'price' => rand(10, 100) * 1000000,
            'link' => '#'
        ];

        $recommendation_products = [
            [
                'id'=> 1,
                'title' => 'Product 1',
                'description' => 'Description for product 1',
                'image' => 'example.jpeg',
                'price' => rand(10, 100) * 1000000,
                'link' => '#'
            ],
            [
                'id'=> 2,
                'title' => 'Product 2',
                'description' => 'Description for product 2',
                'image' => 'example.jpeg',
                'price' => rand(10, 100) * 1000000,
                'link' => '#'
            ],
            [
                'id'=> 3,
                'title' => 'Product 3',
                'description' => 'Description for product 3',
                'image' => 'example.jpeg',
                'price' => rand(10, 100) * 1000000,
                'link' => '#'
            ],
            [
                'id'=> 4,
                'title' => 'Product 4',
                'description' => 'Description for product 4',
                'image' => 'example.jpeg',
                'price' => rand(10, 100) * 1000000,
                'link' => '#'
            ],
            [
                'id'=> 5,
                'title' => 'Product 5',
                'description' => 'Description for product 5',
                'image' => 'example.jpeg',
                'price' => rand(10, 100) * 1000000,
                'link' => '#'
            ]
        ];
        return view('product.show', compact('product', 'recommendation_products'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        //
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
