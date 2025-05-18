<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ImageUploadController extends Controller
{
    /**
     * Handle product image upload.
     */
    public function uploadProductImage(Request $request)
    {
        return $this->handleUpload($request, 'product_images');
    }

    /**
     * Handle profile picture upload.
     */
    public function uploadProfilePicture(Request $request)
    {
        return $this->handleUpload($request, 'profile_pictures');
    }

    /**
     * Reusable upload logic.
     */
    private function handleUpload(Request $request, $folder)
    {
        $validator = Validator::make($request->all(), [
            'image' => 'required|image|max:2048', // 2MB max
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'fail',
                'errors' => $validator->errors(),
            ], 422);
        }

        $path = $request->file('image')->store("uploads/{$folder}", 'public');

        return response()->json([
            'status' => 'success',
            'message' => 'Image uploaded successfully',
            'url' => asset("storage/{$path}"),
        ]);
    }
}
