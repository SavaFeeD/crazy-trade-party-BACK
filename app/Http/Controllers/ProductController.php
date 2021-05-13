<?php

namespace App\Http\Controllers;

use App\Models\ProductIsCategory;
use App\Models\Category;
use App\Models\BuyProduct;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\Product\ProductStoreRequest;
use Illuminate\Support\Collection;

class ProductController extends Controller
{
    public function index() {
        return response()->json(Product::all(), 200);
    }

    public function addViewsCount(Request $request) {
        return Product::incrementViewsCount($request);
    }

    public function getOne($id) {
      $product = Product::where('id', $id)->first();
      $p_c = collect(ProductIsCategory::where('product_id', $id)->get()->all());

      $category = collect([]);
      $p_c->map(function($item) use($category) {
        $category->push(Category::where('id', $item->category_id)->first()->name);
      });

      $buy_count = count(BuyProduct::where('product_id', $id)->get());

      return response()->json([
          'status' => true,
          'body' => [
            'product' => $product,
            'category' => $category->all(),
            'buy_count' => $buy_count
          ]
      ], 200);
    }

    public function store(ProductStoreRequest $request) {
      $user_id = $request->user_id;

      $user = User::where('api_token', $request->bearerToken())->first();
      if ($user->id."" != $request->user_id)
        return response()->json([
            'status' => false,
            'body' => [
                'message' => 'Вы не можете создать товар'
            ]
        ], 403);

      $data = collect($request->all())->filter(function ($value, $key) {
        return $key != 'user_id' || $key != 'category';
      });

      $mode = 'no-cat';
      if (isset($request->category))
        $mode = 'all';

      if ($mode == 'all') {
        $category = explode(', ', $request->category);
        $res = Product::store($data->all(), $category);
      }
      if ($mode == 'no-cat') {
        $res = Product::store($data->all(), 'no-cat');
      }

      if ($res['code'] == 200) {
        return response()->json([
            'status' => $res['status'],
            'body' => [
              "message" => $res['message'],
              "product_id" => $res['product_id']
            ]
        ], $res['code']);
      } else {
        return response()->json([
            'status' => $res['status'],
            'body' => [
              "message" => $res['message']
            ]
        ], $res['code']);
      }
    }

    public function delete(Request $request) {
      $user_id = $request->user_id;
      $user = User::where('api_token', $request->bearerToken())->first();
      if ($user->id."" != $request->user_id)
        return response()->json([
            'status' => false,
            'body' => [
                'message' => 'Вы не можете удалить товар'
            ]
        ], 403);

      $product = Product::find($request->product_id);
      $product->delete();

      return response()->json([
          'status' => true,
          'body' => [
            "message" => "Вы удалили товар"
          ]
      ], 401);
    }
}
