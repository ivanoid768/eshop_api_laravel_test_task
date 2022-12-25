<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ShoppingCart;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ShoppingCartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ShoppingCart  $shoppingCart
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $shoppingCart = ShoppingCart::find($id);

        return response()->json([
            'cart' => $shoppingCart,
            'cart_products' => $shoppingCart->products()->get()
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ShoppingCart  $shoppingCart
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ShoppingCart $shoppingCart)
    {
        //
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ShoppingCart  $shoppingCart
     * @return \Illuminate\Http\JsonResponse
     */
    public function addProduct(Request $request, $id, $product_id)
    {
        $product = Product::find($product_id);
        if(!$product){
            return response()->json(['error'=>'invalid_product_id', 404]);
        }

        $cart = ShoppingCart::find($id);

        $cart->products()->attach($product);

        return response()->json([
            'cart' => $cart,
            'product' => $product,
        ], 201);
    }

    public function removeProduct(Request $request, $id, $product_id)
    {
        $product = Product::find($product_id);
        $cart = ShoppingCart::find($id);

        $cart->products()->detach($product);

        return response()->json([
            'cart' => $cart,
            'product_removed_from_the_cart' => $product,
        ], 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ShoppingCart  $shoppingCart
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $shoppingCart = ShoppingCart::find($id);

        $shoppingCart->products()->detach();

        return response()->json([
            'cart' => $shoppingCart
        ], 201);
    }
}