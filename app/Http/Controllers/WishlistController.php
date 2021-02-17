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
            $wl = Wishlist::where('id', $id)->first();

            if (!$wl)
                return response()->json([
                    'status' => false,
                    'body' => [
                        'message' => 'Записи с таким id не существует'
                    ]
                ], 404);

            if ($user->id != $wl->user_id)
                throw new RouteNotFoundException;

            $wl->delete();

            return response()->json([
                'message' => 'Deleted'
            ], 202);

        } catch (RouteNotFoundException $error) {

            return response()->json([
                'status' => false,
                'body' => [
                    'message' => 'Токен не принадлежит пользователю который создал запись в wl'
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
