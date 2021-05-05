<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Requests\Product\ProductStoreRequest;


class ProductController extends Controller
{
    public function index() {
        return response()->json(Product::all(), 200);
    }

    public function addViewsCount(Request $request) {
        return Product::incrementViewsCount($request);
    }

    public function getOne($id) {
        return response()->json([
            'status' => true,
            'body' => Product::where('id', $id)->first()
        ], 200);
    }

    public function store(ProductStoreRequest $request) {
      $data = $request;

      $res = Product::store($data);

      return response()->json([
          'status' => true,
          'body' => $res
      ], 200);
    }
}
