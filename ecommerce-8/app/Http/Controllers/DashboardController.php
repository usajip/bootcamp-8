<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Data: total product, total product_category, total order, total user, graph order weekly, table order latest
        $totals_data = [
            [
                'name'=> 'Product',
                'total' => 100,
                'color' => '#dbd8ff',
                'icon_color' => '#7c3aed',
                'icon'=> 'inventory_2',
            ],
            [
                'name'=> 'Product Category',
                'total' => 10,
                'color' => '#c7d2fe',
                'icon_color' => '#4c1d95',
                'icon'=> 'category',
            ],
            [
                'name'=> 'Order',
                'total' => 50,
                'color' => '#d1fae5',
                'icon_color' => '#065f46',
                'icon'=> 'shopping_cart',
            ],
            [
                'name'=> 'User',
                'total' => 20,
                'color' => '#dbeafe',
                'icon_color' => '#1e3a8a',
                'icon'=> 'people',
            ],
            [
                'name'=>'Product Clicks',
                'total' => 500,
                'color' => '#fef3c7',
                'icon_color' => '#78350f',
                'icon' => 'trending_up',
            ]
        ];

        // chart data weekly order (total order per day and total revenue per day in the last 7 days) display in dashbard view with chart js
        $weekly_order_data = [
            ['date' => '2024-06-01', 'total_order' => 5, 'total_revenue' => 100000],
            ['date' => '2024-06-02', 'total_order' => 10, 'total_revenue' => 200000],
            ['date' => '2024-06-03', 'total_order' => 5, 'total_revenue' => 20000],
            ['date' => '2024-06-04', 'total_order' => 2, 'total_revenue' => 450000],
            ['date' => '2024-06-05', 'total_order' => 5, 'total_revenue' => 250000],
            ['date' => '2024-06-06', 'total_order' => 3, 'total_revenue' => 60000],
            ['date' => '2024-06-07', 'total_order' => 3, 'total_revenue' => 750000],
        ];

        // table order latest (latest 5 order with order id, customer name, total price, status, order date) display in dashboard view
        $recent_orders = [
            [
                'order_number'=> 'ORD-001',
                'name' => 'John Doe',
                'total_price' => 100000,
                'status' => 'pending',
                'order_date' => '2024-06-01',
            ],
            [
                'order_number'=> 'ORD-002',
                'name' => 'Jane Doe',
                'total_price' => 200000,
                'status' => 'completed',
                'order_date' => '2024-06-02',
            ],
            [
                'order_number'=> 'ORD-003',
                'name' => 'Bob Smith',
                'total_price' => 150000,
                'status' => 'pending',
                'order_date' => '2024-06-03',
            ],
            [
                'order_number'=> 'ORD-004',
                'name' => 'Alice Johnson',
                'total_price' => 250000,
                'status' => 'completed',
                'order_date' => '2024-06-04',
            ],
            [
                'order_number'=> 'ORD-005',
                'name' => 'Charlie Brown',
                'total_price' => 300000,
                'status' => 'pending',
                'order_date' => '2024-06-05',
            ],
        ];
        return view('dashboard', compact('totals_data', 'weekly_order_data', 'recent_orders'));
    }
}
