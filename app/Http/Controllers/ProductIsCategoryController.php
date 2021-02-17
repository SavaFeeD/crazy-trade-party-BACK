<?php

namespace App\Http\Controllers;

use App\Models\ProductIsCategory;
use Illuminate\Http\Request;

class ProductIsCategoryController extends Controller
{
    public function index() {
        return response()->json(ProductIsCategory::all());
    }
}
