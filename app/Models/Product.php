<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use App\Models\File;
use App\Models\ProductIsCategory;

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
        'dataset',
        'user_id'
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

    static public function store($data, $category) {
        $dataset_name = File::setPublicStore($data['dataset']);
        $dataset_url = File::getPublicUrl($dataset_name);
        $data['dataset'] = $dataset_url;
        if (isset($data['img'])) {
          $img_name = File::setPublicStore($data['img']);
          $img_url = File::getPublicUrl($img_name);
          $data['img'] = $img_url;
        }
        try {
          $product = Product::create($data);
          if ($category != 'no-cat') {
            collect($category)->map(function ($cat) use($product) {
              ProductIsCategory::create([
                "product_id" => $product->id,
                "category_id" => $cat
              ]);
            });
          }
        } catch (Exception $e) {
          return [
            "status" => false,
            "message" => 'Произошла ошибка во время создания товара',
            "code" => 500
          ];
        }

        return [
          "status" => true,
          "message" => 'Товар создан',
          "product_id" => $product->id,
          "code" => 200
        ];
    }
}
