<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use App\Models\File;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'short_description',
        'description',
        'price',
        'views_count',
        'img',
        'dataset'
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

    static public function store($data) {
        $dataset_name = File::setPublicStore($data->dataset);
        $img_name = File::setPublicStore($data->img);
        // $attr_name = AttrName::create($request->all());
    }
}
