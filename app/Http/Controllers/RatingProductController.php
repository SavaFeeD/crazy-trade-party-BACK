<?php

namespace App\Http\Controllers;

use App\Models\AttrToProduct;
use App\Models\BuyProduct;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use App\Models\Product;

class RatingProductController extends Controller
{
    public function index() {
        return response()->json([
            'message' => 'Rating!!!'
        ]);
    }

    public function topAbsoluteProduct() {
        // (views_count + wl_count) * buy_count

        $list = collect([]);

        $products = collect(Product::all());

        $products->map(function ($product) use($list){
            $list->push([
                'id' => $product->id,
                'rating' => 0
            ]);

            $views_count = $product->views_count;
            $wl_count = 0;
            $buy_count = 0;


            $wls = Wishlist::where('product_id', $product->id);
            if ($wls->first())
                $wl_count = collect($wls)->count();

            $buys = collect([]);// ХУЙ ЕГО ЗНАЕТ КАК ЭТУ ХУЙНЮ ПОФИКСИТЬ
            collect(AttrToProduct::where('product_id', $product->id))->map(function ($item) use($buys) {
                $buys->push(BuyProduct::where('attr_to_product_id', $item->id));
            }); // ХУЙ ЕГО ЗНАЕТ КАК ЭТУ ХУЙНЮ ПОФИКСИТЬ

            if ($buys->count() != 0)
                $buy_count = collect($buys)->count();

            $list[$list->count()-1] = ($views_count + $wl_count) * $buy_count;
        });

        return response()->json([
            'status' => true,
            'body' => $list->all()
        ]);
    }
}
