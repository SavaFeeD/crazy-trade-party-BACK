<?php

namespace App\Http\Controllers;

use App\Models\AttrData;
use App\Models\AttrName;
use App\Models\AttrToProduct;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index() {
        return response()->json(Product::all(), 200);
    }

    public function addViewsCount(Request $request) {
        return Product::incrementViewsCount($request);
    }

    public function getOne($id) {
        $attrs = [];

        $attrToProducts = collect(AttrToProduct::all())->filter(function ($item) use($id) {
            return $item->product_id."" === $id;
        });

        $id_list = collect();
        foreach ($attrToProducts->all() as $atp) {
            $id_list->push($atp->attr_data_id);
        }

        $attrDatas = Controller::getDataList(AttrData::class, $id_list->all());

        $id_list = collect();
        foreach ($attrDatas as $ad) {
            $id_list->push($ad->attr_id);
        }

        $attrNames = Controller::getDataList(AttrName::class, $id_list->all());

        foreach ($attrNames as $name) {
            $check = true;
            foreach ($attrs as $a) {
                if ($a['id_name'] === $name->id)
                    $check = false;
            }

            if ($check)
                array_push($attrs, [
                    'id_name' =>  $name->id,
                    'name' => $name->name,
                    'values' => []
                ]);


            foreach ($attrDatas as $data_value)
                if ($data_value->attr_id === $name->id)
                    foreach ($attrs as $idx => $a)
                        if ($a['id_name'] === $name->id)
                            array_push($attrs[$idx]['values'], [
                                'id' => $data_value->id,
                                'text' => $data_value->value
                            ]);
        }

        foreach ($attrs as $i => $attr) {
            $array = $attr['values'];

            $ids = array_column($array, 'id');
            $ids = array_unique($ids);
            $array = array_filter($array, function ($key, $value) use ($ids) {
                return in_array($value, array_keys($ids));
            }, ARRAY_FILTER_USE_BOTH);

            $attrs[$i]['values'] = $array;
        }

        return response()->json([
            'status' => true,
            'body' => [
                'product' => Product::where('id', $id)->first(),
                'attrs' => $attrs
            ]
        ], 200);
    }
}
