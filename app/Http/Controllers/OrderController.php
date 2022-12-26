<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index($user_id)
    {
        $orders = Order::where('user_id', $user_id)->get();

        foreach ($orders as $order) {
            $order->products->toArray();
        }

        return response()->json($orders, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store($user_id)
    {
        $user = User::find($user_id);
        $cart = $user->shoppingCart()->first();

        $order = new Order();
        $user->orders()->save($order);

        $products = $cart->products()->get();

        foreach ($products as $product) {
            $order->products()->attach($product);
        }

        $cart->products()->detach();

        return response()->json([
            'user' => $user,
            'new_order' => $order,
            'order_products' => $order->products()->get()
        ], 200);
    }
}