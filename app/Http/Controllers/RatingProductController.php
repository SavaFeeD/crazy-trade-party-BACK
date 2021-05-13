<?php

namespace App\Http\Controllers;

use App\Models\BuyProduct;
use App\Models\Wishlist;
use App\Models\Product;

use Illuminate\Http\Request;

class RatingProductController extends Controller
{
    public function index() {
        return response()->json([
            'message' => 'Rating!!!'
        ]);
    }

    public function absoluteProduct() {
        // (views_count + wl_count*10 + buy_count*1000) / 3

        $views_count = collect([]);
        $wl_count = collect([]);
        $buy_count = collect([]);

        $products = collect(Product::all());

        $products->map(function ($product) use($views_count) {
          $views_count->push($product->views_count);
        });

        $products->map(function ($product) use($wl_count) {
          $wls = Wishlist::where('product_id', $product->id)->get();
          if ($wls->first() != null) {
            $count = count($wls);
          } else {
            $count = 0;
          }
          $wl_count->push($count);
        });

        $products->map(function ($product) use($buy_count) {
          $buys = BuyProduct::where('product_id', $product->id)->get();
          if ($buys->first() != null) {
            $count = count($buys);
          } else {
            $count = 0;
          }
          $buy_count->push($count);
        });

        $analys = collect([]);
        $wl_count = $wl_count->all();
        $buy_count = $buy_count->all();

        $views_count->map(function ($val, $key) use($wl_count, $buy_count, $analys) {
            $analys->push((int) round(($val+$wl_count[$key]*10+$buy_count[$key]*1000)/3));
        });

        $data = collect([]);
        $analys->sort()->reverse()->map(function ($rate, $product_id) use($data, $products) {
          if (count($data->all()) == 10) {
            return;
          }

          $product_name = '';

          foreach ($products as $key => $product) {
            if ($product->id == $product_id) {
              $product_name = $product->name;
              break;
            }
          }

          $data->push([
            "product_id" => $product_id,
            "product_name" => $product_name,
            "rate" => $rate
          ]);
        });

        return response()->json([
          "status" => true,
          "body" => [
            "rate" => $data->all()
          ]
        ], 200);
    }
}
