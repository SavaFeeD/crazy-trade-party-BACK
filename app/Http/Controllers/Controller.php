<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    static public function getDataList($MODEL, $id_list)
    {
        $collection = collect([]);

        foreach ($id_list as $id)
            $collection->push(collect($MODEL::all())->filter(function ($item) use ($id) {
                return $item->id === $id;
            })->first());

        return $collection->all();
    }
}
