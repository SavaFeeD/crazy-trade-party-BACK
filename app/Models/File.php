<?php

namespace App\Models;
use Illuminate\Support\Facades\Storage;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    use HasFactory;

    public static function getPublicUrl($filename) {
      return asset("storage/upload/$filename");
    }

    public static function setPublicStore($file) {
      $filename = $file->getClientOriginalName();
      $savefile = Storage::disk('public')->put('upload', $file);
      $filename = explode('/', $savefile);
      $filename = $filename[count($filename)-1];
      return $filename;
    }
}
