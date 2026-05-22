<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $title = 'Home Page';
        $products = [
            [
                'id'=> 1,
                'title' => 'Product 1',
                'description' => 'Description for product 1',
                'image' => 'example.jpeg',
                'link' => '#'
            ],
            [
                'id'=> 2,
                'title' => 'Product 2',
                'description' => 'Description for product 2',
                'image' => 'example.jpeg',
                'link' => '#'
            ],
            [
                'id'=> 3,
                'title' => 'Product 3',
                'description' => 'Description for product 3',
                'image' => 'example.jpeg',
                'link' => '#'
            ],
            [
                'id'=> 4,
                'title' => 'Product 4',
                'description' => 'Description for product 4',
                'image' => 'example.jpeg',
                'link' => '#'
            ],
            [
                'id'=> 5,
                'title' => 'Product 5',
                'description' => 'Description for product 5',
                'image' => 'example.jpeg',
                'link' => '#'
            ],
            [
                'id'=> 6,
                'title' => 'Product 6',
                'description' => 'Description for product 6',
                'image' => 'example.jpeg',
                'link' => '#'
            ],
            [
                'id'=> 7,
                'title' => 'Product 7',
                'description' => 'Description for product 7',
                'image' => 'example.jpeg',
                'link' => '#'
            ],
        ];
        return view('home', compact('title', 'products'));
    }
}
