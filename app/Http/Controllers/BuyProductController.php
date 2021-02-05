<?php

namespace App\Http\Controllers;

use App\Models\AttrData;
use App\Models\AttrName;
use App\Models\AttrToProduct;
use App\Models\BuyProduct;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use App\Models\User;

class BuyProductController extends Controller
{
    public function index() {
        return response()->json([BuyProduct::all(), 200]);
    }

    public function user($slug) {
        try {

            $validated = Validator::make(['slug' => $slug], [
                'slug' => 'required'
            ]);

            if ($validated->fails())
                throw new NotFoundHttpException;

            $user = User::where('slug', $slug)->first();

            if ($user === null)
                throw new NotFoundHttpException;

            $buy_list = collect(BuyProduct::all())->filter(function ($item) use($user) {
                return $item->user_id === $user->id;
            });

            $list = collect();
            foreach ($buy_list->all() as $bl) {
                $list->push([
                    'product' => Product::where('id', AttrToProduct::where('id', $bl->attr_to_product_id)->first()->product_id)->first(),
                    'attr' => [
                        'name' => AttrName::where('id',
                            AttrData::where('id',
                                AttrToProduct::where('id', $bl->attr_to_product_id)->first()->attr_data_id)->first()->attr_id)->first()->name,
                        'value' => AttrData::where('id',
                                AttrToProduct::where('id', $bl->attr_to_product_id)->first()->attr_data_id)->first()->value
                    ]
                ]);
            }

//            $products = Product::getProductList($id_list->all());

            return response()->json([
                'status' => true,
                'body' => [
                    'product_list' => $list
                ]
            ], 200);

        } catch (NotFoundHttpException $error) {
            return response()->json([
                'status' => false,
                'body' => [
                    'message' => 'Ошибка с SLUG пользователя'
                ]
            ], 400);
        }
    }
}
