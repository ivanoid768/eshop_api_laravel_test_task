<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ShoppingCart;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ShoppingCartController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ShoppingCart  $shoppingCart
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Request $request)
    {
        $user = $request->user();

        $shoppingCart = $user->shoppingCart;
        $shoppingCart->products;

        return response()->json([
            'cart' => $shoppingCart,
            // 'cart_products' => $shoppingCart->products
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ShoppingCart  $shoppingCart
     * @return \Illuminate\Http\JsonResponse
     */
    public function addProduct(Request $request, $product_id)
    {
        $user = $request->user();

        $product = Product::find($product_id);
        if(!$product){
            return response()->json(['error'=>'invalid_product_id', 404]);
        }

        $cart = $user->shoppingCart;

        $cart->products()->attach($product);

        return response()->json([
            'cart' => $cart,
            'product' => $product,
        ], 201);
    }

    public function removeProduct(Request $request, $product_id)
    {
        $user = $request->user();

        $product = Product::find($product_id);
        $cart = $user->shoppingCart;

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
    public function destroy(Request $request)
    {
        $shoppingCart = $request->user()->shoppingCart;;

        $shoppingCart->products()->detach();
        $shoppingCart->products;

        return response()->json([
            'cart' => $shoppingCart
        ], 201);
    }
}