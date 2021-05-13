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
        return response()->json(BuyProduct::all(), 200);
    }

    public function user_product($slug, $id_product) {
        try {

            $validated = Validator::make(['slug' => $slug, 'id_product' => $id_product], [
                'slug' => 'required',
                'id_product' => 'required'
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
            $check = false;
            foreach ($buy_list->all() as $bl) {
                $product = Product::where('id', $bl->product_id)->first();
                if ($product->id == $id_product) {
                  $check = true;
                }
            }

            return response()->json([
                'status' => true,
                'body' => [
                    'check' => $check
                ]
            ], 200);

        } catch (NotFoundHttpException $error) {
            return response()->json([
                'status' => false,
                'body' => [
                    'message' => 'Введите все параметры'
                ]
            ], 400);
        }
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
                $list->push(Product::where('id', $bl->product_id)->first());
            }

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

    public function buy(Request $request) {
        try {
            $user = User::where('api_token', $request->bearerToken())->first();
            if ($user->id."" != $request->user_id)
                throw new NotFoundHttpException;

            $product = Product::where('id', $request->product_id)->first();
            if (!$product)
                return response()->json([
                    'status' => false,
                    'body' => [
                        'message' => 'Такого товара не существует'
                    ]
                ], 404);

            BuyProduct::create($request->all());

        } catch (NotFoundHttpException $error) {
            return response()->json([
                'status' => false,
                'body' => [
                    'message' => 'Вы не можете добавлять другим товары в wl!'
                ]
            ], 403);
        }

        return response()->json([
            'status' => true,
            'body' => [
                'message' => 'Покупка прошла успешно'
            ]
        ], 200);
    }
}
