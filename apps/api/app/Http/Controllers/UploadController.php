<?php

namespace App\Http\Controllers;

use App\Http\Requests\UploadRequest;
use Illuminate\Support\Facades\Storage;

class UploadController extends Controller
{
    /**
     * @requestMediaType multipart/form-data
     */
    public function upload(UploadRequest $request)
    {
        $path = $request->file('file')->store('uploads');
        $url = Storage::url($path);
        return [
            'path' => $path,
            'url' => $url,
        ];
    }
}