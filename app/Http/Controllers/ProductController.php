<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Validator;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getProducts(Request $request)
    {
        $validatedData = $request->validate([
            'page' => ['numeric', 'min:0'],
            'perpage' => ['numeric', 'min:0'],

            'sortby' => [Rule::in(['name', 'description', 'categoryid', 'price']), 'nullable'],
            'sortdirect' => [Rule::in(['asc', 'desc']), 'nullable'],

            "name" => ['string', 'max:255', 'nullable'],
            "description" => ['string', 'nullable'],
            // "slug" => ['uuid','nullable'],
            "categoryid" => ['numeric', 'nullable', 'exists:categories,id'],
            "pricefrom" => ['integer', 'nullable', 'min:1'],
            "priceto" => ['integer', 'nullable', 'min:1'],
            "length" => ['integer', 'nullable', 'min:1'],
            "width" => ['integer', 'nullable', 'min:1'],
            "weight" => ['integer', 'nullable', 'min:1']
        ]);

        $query = Product::query();

        if (array_key_exists('name', $validatedData)) {
            $query = $query->whereFullText('name', $validatedData['name']);
        }
        if (array_key_exists('description', $validatedData)) {
            $query = $query->whereFullText('description', $validatedData['description']);
        }
        if (array_key_exists('categoryid', $validatedData)) {
            $query = $query->where('categoryid', $validatedData['categoryid']);
        }
        if (array_key_exists('pricefrom', $validatedData)) {
            $query = $query->where('price', '>=', $validatedData['pricefrom']);
        }
        if (array_key_exists('priceto', $validatedData)) {
            $query = $query->where('price', '<=', $validatedData['priceto']);
        }

        if (array_key_exists('sortby', $validatedData)) {
            $direction = 'asc';
            if (array_key_exists('sortdirect', $validatedData)) {
                $direction = $validatedData['sortdirect'];
            }

            $query = $query->orderBy($validatedData['sortby'], $direction);
        } else {
            $query = $query->orderBy('id');
        }

        $count = $query->count();

        $page = 1;
        $per_page = 10;
        if (array_key_exists('page', $validatedData)) {
            $page = $validatedData['page'];
        }
        if (array_key_exists('perpage', $validatedData)) {
            $per_page = $validatedData['perpage'];
        }

        $query = $query->offset(($page - 1) * $per_page)->limit($per_page);
        $products = $query->get();

        return response()->json([
            'data' => $products,
            'size' => $products->count(),
            'total' => $count
        ], 200);
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