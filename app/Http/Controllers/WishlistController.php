<?php

namespace App\Http\Controllers;

use App\Http\Requests\WLRequest;
use App\Models\Product;
use App\Models\Wishlist;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Exception\RouteNotFoundException;

class WishlistController extends Controller
{
    public function index() {
        return response()->json(Wishlist::all(), 200);
    }

    public function user_product_wishlist($slug, $id_product) {
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

            $wl_list = collect(Wishlist::all())->filter(function ($item) use($user) {
                return $item->user_id === $user->id;
            });

            $list = collect();
            $check = false;
            foreach ($wl_list->all() as $wl) {
                $product = Product::where('id', $wl->product_id)->first();
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
                    'message' => 'Введите все параметры правильно'
                ]
            ], 400);
        }
    }

    public function add(WLRequest $request) {
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

            Wishlist::create($request->all());
            return response()->json([
                'status' => true,
                'body' => [
                    'message' => 'Успешно добавлено'
                ]
            ], 200);
        } catch (NotFoundHttpException $error) {
            return response()->json([
                'status' => false,
                'body' => [
                    'message' => 'Вы не можете добавлять другим товары в wl!'
                ]
            ], 403);
        }
    }

    public function delete(Request $request, $id) {
        try {
            $user = User::where('api_token', $request->bearerToken())->first();
            $wl = collect(Wishlist::where('product_id', $id)->get()->all());

            $wl->map(function ($item) use($user) {
              if ($item->user_id == $user->id) {
                $item->delete();
              }
            });

            return response()->json([
                'message' => 'Deleted'
            ], 202);

        } catch (RouteNotFoundException $error) {

            return response()->json([
                'status' => false,
                'body' => [
                    'message' => 'Какая-то ошибка'
                ]
            ], 300);
        }
    }

    public function getWLForUser($slug) {
        try {

            $validated = Validator::make(['slug' => $slug], [
                'slug' => 'required'
            ]);

            if ($validated->fails())
                throw new NotFoundHttpException;

            $user = User::where('slug', $slug)->first();

            if ($user === null)
                throw new NotFoundHttpException;

            $wl_list = collect(Wishlist::all())->filter(function ($item) use($user) {
                return $item->user_id === $user->id;
            });

            $id_list = collect();
            foreach ($wl_list->all() as $wl) {
                $id_list->push($wl->product_id);
            }

            $products = Controller::getDataList(Product::class, $id_list->all());

            return response()->json([
                'status' => true,
                'body' => [
                    'product_list' => $products
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
