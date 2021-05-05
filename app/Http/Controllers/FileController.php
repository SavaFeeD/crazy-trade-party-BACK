<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\File;

class FileController extends Controller
{
    public function get(Request $request) {
      try {

        $url = File::getPublicUrl($request->name);

      } catch (Exception $e) {
        return response()->json([
            'status' => false,
            'body' => [
                'message' => 'Произошла во время поиска файла'
            ]
        ], 400);
      }

      return response()->json([
          'status' => true,
          'body' => [
            "message" => 'Операция прошла успешно',
            "url" => $url
          ]
      ], 200);
    }

    public function store(Request $request) {
      try {

        $filename = File::setPublicStore($request->file('file'));

      } catch (Exception $e) {
        return response()->json([
            'status' => false,
            'body' => [
                'message' => 'Произошла во время сохранения'
            ]
        ], 400);
      }

      return response()->json([
          'status' => true,
          'body' => [
            "message" => "Загрузка завершена",
            "filename" => $filename,
            "url" => File::getPublicUrl($filename)
          ]
      ], 200);
    }
}
