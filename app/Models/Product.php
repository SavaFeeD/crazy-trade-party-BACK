<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'short_description',
        'description',
        'price',
        'views_count',
        'numbers',
        'img'
    ];

    static public function incrementViewsCount($request): \Illuminate\Http\JsonResponse
    {
        try {
            $product = Product::where('id', $request->id)->first();
            if (!$product)
                throw new NotFoundHttpException;

            $product->views_count += 1;
            $product->save();

            return response()->json([
                'status' => true,
                'body' => [
                    'message' => '+1 к статистике просмотра товара!',
                    'number' => $product->views_count
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

    static public function decrementNumbers($request): \Illuminate\Http\JsonResponse
    {
        try {
            $product = Product::where('id', $request->id)->first();
            if (!$product)
                throw new NotFoundHttpException;

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
