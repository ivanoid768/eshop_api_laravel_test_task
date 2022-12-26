<?php

namespace App\Http\Controllers;

use App\Models\ShoppingCart;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $users = User::all();

        return response()->json($users, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $input = $request->post();

        $user = User::create($input);
        $cart = new ShoppingCart();
        $user->shoppingCart()->save($cart);

        return response()->json([
            'user' => $user,
            'cart' => $cart
        ], 201);
    }
}