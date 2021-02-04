<?php

namespace App\Http\Controllers;

use App\Http\Requests\WLRequest;
use App\Models\Product;
use App\Models\Wishlist;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use function GuzzleHttp\Promise\all;

class WishlistController extends Controller
{
    public function add(WLRequest $request) {
        $wl = Wishlist::create($request->all());
        return response()->json($wl, 200);
    }

    public function delete($id) {
        Wishlist::where('id', $id)->delete();
        return response()->json([
            'message' => 'Deleted'
        ], 200);
    }

    public function getWLForUser($slug) {
        try {
            $data = [
                'slug' => $slug
            ];

            $validated = Validator::make($data, [
                'slug' => 'required'
            ]);

            if ($validated->fails())
                throw new NotFoundHttpException;

            $user = User::where('slug', $slug)->first();

            $wl_list = collect(Wishlist::all())->filter(function ($item) use($user) {
                return $item->user_id === $user->id;
            });

            $id_list = collect();
            foreach ($wl_list->all() as $wl) {
                $id_list->push($wl->product_id);
            }

            $products = Product::getProductList($id_list->all());

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
