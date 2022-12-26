<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Http\Controllers\Controller;
use App\Models\ShoppingCart;
use App\Models\User;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index($parent_id)
    {
        //
        if($parent_id && $parent_id != 'null'){
            $categories = Category::where('parent_id', $parent_id)->get();
        }else{
            $categories = Category::whereNull('parent_id')->get();
        }

        return response()->json($categories, 200);
    }
}
