<?php

namespace App\Http\Controllers;

use App\Http\Requests\Product\AttrNameRequest;
use App\Models\AttrName;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class AttrNameController extends Controller
{
    public function store(AttrNameRequest $request) {
        $attr_name = AttrName::create($request->all());

        return response()->json([
            'status' => true,
            'body' => [
                'message' => 'Атрибут '.$request->name.' создан',
                'attr_name' => $attr_name
            ]
        ]);
    }

    public function getAttrName($id) {
        try {
            $attr_name = AttrName::where('id', $id);

            if (!$attr_name)
                throw new NotFoundHttpException;

            return response()->json([
                'status' => true,
                'body' => [
                    'attr_name' => $attr_name
                ]
            ]);
        } catch (NotFoundHttpException $error) {
            return response()->json([
                'status' => false,
                'body' => [
                    'message' => 'Атрибут не найден'
                ]
            ], 404);
        }

    }
}
