<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index() {
        return response()->json(Product::all(), 200);
    }

    public function addViewsCount(Request $request) {
        return Product::incrementViewsCount($request);
    }

    public function getOne($id) {
        return Product::where('id', $id)->first();
    }
}
