<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;
use Validator;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $filter = $request->query();

        $validatedData = $request->validate([
            'page' => ['numeric', 'min:0'],
            'perpage' => ['numeric', 'min:0'],

            'sortby' => [Rule::in(['name', 'description', 'categoryid', 'price']), 'nullable'],

            "name" => ['string', 'max:255', 'nullable'],
            "description" => ['string', 'nullable'],
            // "slug" => ['uuid','nullable'],
            "categoryid" => ['numeric', 'nullable', 'exists:categories,id'],
            "price" => ['integer', 'nullable', 'min:1'],
            "length" => ['integer', 'nullable', 'min:1'],
            "width" => ['integer', 'nullable', 'min:1'],
            "weight" => ['integer', 'nullable', 'min:1']
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        //
        $input = $request->all();

        $validator = Validator::make($input, [
            'name' => 'required',
            'description' => 'required'
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }
        ;

        $product = Product::create($input);

        return response()->json([
            "success" => true,
            "message" => "Product created successfully.",
            "data" => $product
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        //
    }
}