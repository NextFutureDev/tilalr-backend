<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\IslandDestination;

class TestUploadController extends Controller
{
    /**
     * Test file upload
     */
    public function upload(Request $request)
    {
        try {
            $request->validate([
                'image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:10240',
            ]);

            $file = $request->file('image');
            
            // Debug info
            $info = [
                'original_name' => $file->getClientOriginalName(),
                'size' => $file->getSize(),
                'mime' => $file->getMimeType(),
                'is_valid' => $file->isValid(),
            ];

            // Try to store
            $path = $file->store('islands', 'public');
            
            $info['stored_path'] = $path;
            $info['full_path'] = config('filesystems.disks.public.root') . '/' . $path;
            $info['file_exists'] = file_exists($info['full_path']);
            $info['web_url'] = config('filesystems.disks.public.url') . '/' . $path;

            return response()->json([
                'success' => true,
                'message' => 'File uploaded successfully',
                'data' => $info,
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
                'code' => $e->getCode(),
            ], 422);
        }
    }

    /**
     * Test setting image on island
     */
    public function setImage(Request $request, $id)
    {
        try {
            $request->validate([
                'image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:10240',
            ]);

            $island = IslandDestination::findOrFail($id);
            $file = $request->file('image');
            
            // Store file
            $path = $file->store('islands', 'public');
            
            // Update island
            $island->update(['image' => '/' . $path]);
            
            return response()->json([
                'success' => true,
                'message' => 'Image uploaded and saved',
                'data' => [
                    'path' => $island->image,
                    'url' => config('filesystems.disks.public.url') . $island->image,
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
                'code' => $e->getCode(),
            ], 422);
        }
    }
}
