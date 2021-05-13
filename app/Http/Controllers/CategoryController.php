<?php

namespace App\Http\Controllers;

use App\Models\ProductIsCategory;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class CategoryController extends Controller
{
    public function index() {
        return response()->json(Category::all(), 200);
    }

    public function category($id) {
        $category_name = Category::find($id);
        if ($category_name == null)
          return response()->json([
            "status" => false,
            "body" => [
              "message" => 'Такой категории не существует'
            ]
          ], 404);

        $category = collect(ProductIsCategory::where('category_id', $id)->get());
        $products_id = collect([]);
        $category->map(function($cat) use($products_id) {
          $products_id->push($cat->product_id);
        });

        $products = self::getDataList(Product::class, $products_id);


        return response()->json([
          "status" => true,
          "body" => [
            "category" => $category_name,
            "products" => $products
          ]
        ], 200);
    }

    public function create(Request $request) {
        $validated = Validator::make(['name' => $request->name], [
            'name' => 'required'
        ]);

        if ($validated->fails())
          return response()->json([
              'status' => false,
              'body' => [
                  'message' => "Вы не указали название категории"
              ]
          ], 400);

        $cat = Category::create($request->all());
        $cat->save();

        return response()->json([
            'status' => true,
            'body' => [
                'message' => 'Вы успешно создали категорию '.$request->name
            ]
        ], 201);
    }
}
