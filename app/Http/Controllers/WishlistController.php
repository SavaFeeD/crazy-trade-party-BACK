<?php

namespace App\Http\Controllers;

use App\Http\Requests\WLRequest;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class WishlistController extends Controller
{
    public function add(WLRequest $request) {
        $wl = Wishlist::create($request->all());
        return response()->json($wl, 200);
    }

    public function getWL(Request $request) {
        try {
            $validated = Validator::make($request->all(), [
                'user_id' => 'required|integer'
            ]);

            if ($validated->fails())
                throw new NotFoundHttpException;

        } catch (NotFoundHttpException $error) {
            return response()->json([
                'status' => false,
                'body' => [
                    'message' => $error
                ]
            ]);
        }

    }
}
