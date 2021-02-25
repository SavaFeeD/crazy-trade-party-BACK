<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class AttrToProduct extends Model
{
    use HasFactory;

    protected $fillable = ['attr_data_id', 'product_id', 'numbers'];

    static public function decrementNumbers($request): \Illuminate\Http\JsonResponse
    {
        try {
            $product = AttrToProduct::where('id', $request->id)->first();
            if (!$product)
                throw new NotFoundHttpException();

            $after_product_numbers = $product->numbers - $request->num;

            if ($after_product_numbers < 0)
                return response()->json([
                    'status' => false,
                    'body' => [
                        'message' => 'У нас недостаточно товаров (осталось '.$product->numbers.'шт.)',
                    ]
                ]);

            $product->numbers = $after_product_numbers;
            $product->save();

            return response()->json([
                'status' => true,
                'body' => [
                    'message' => 'Спасибо за покупку!',
                    'number' => $request->num,
                    'product' => $product
                ]
            ], 200);
        } catch (NotFoundHttpException $error) {
            return response()->json([
                'status' => false,
                'body' => [
                    'message' => 'Такого товара не существует'
                ]
            ], 404);
        }
    }
}
