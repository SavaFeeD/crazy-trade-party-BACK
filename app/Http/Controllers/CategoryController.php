<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class CategoryController extends Controller
{
    public function index() {
        return response()->json(Category::all());
    }

    public function create(Request $request) {
        $validated = Validator::make(['name' => $request->name], [
            'name' => 'required'
        ]);

        if ($validated->fails())
            throw new NotFoundHttpException();

        $cat = Category::create($request->all());
        $cat->save();

        return response()->json([
            'status' => true,
            'body' => [
                'message' => 'Вы успешно создали категорию '.$request->name
            ]
        ], 201);
    }
}
