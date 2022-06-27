<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class MediaController extends Controller
{
    public function destroy(Request $request)
    {
        [$mediaId] = $request->query();
        
        $media = Media::find($mediaId);
        $model_type = $media->model_type;

        $model = $model_type::find($media->model_id);
        $model->deleteMedia($media->id);
    }
}
