<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\ImageUploadRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ImageController extends Controller
{
    public function upload(ImageUploadRequest $request)
    {
        $file = $request->file('image');
        $name = Str::random(10);
        $url = Storage::putFileAs('images', $file, $name .  '.' . $file->extension());

        return ['url' => env('APP_URL') . '/' . $url];
    }
}
