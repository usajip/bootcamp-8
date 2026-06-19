<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $orders = Order::orderBy('created_at', 'desc')->paginate(10);
        return view('dashboards.orders.index', compact('orders'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if(Auth::check()){
            $cart_items = CartItem::with('product')
                            ->where('user_id', Auth::id())
                            ->whereHas('product', function($query) {
                                $query->where('stock', '>', 0);
                            })
                            ->get();
            if($cart_items->isEmpty()){
                return redirect()->route('cart')->withError('Keranjang Anda kosong atau semua produk dalam keranjang sudah habis.');
            }
            $user = Auth::user();
            return view('orders.checkout', compact('cart_items', 'user'));
        }else{
            return redirect()->route('login')->withError('Anda harus login untuk melakukan checkout.');
        }
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
    public function show(Order $order)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        //
    }
}
