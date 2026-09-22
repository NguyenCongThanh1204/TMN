<?php

namespace App\Http\Controllers;

use Cloudinary\Api\Utils\ApiUtils;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CloudinarySignatureController extends Controller
{
    public function __invoke(Request $request): JsonResponse
    {
        $data = $request->validate([
            'folder' => ['required', 'string', 'regex:/^[a-zA-Z0-9_\/-]+$/', 'max:180'],
            'public_id' => ['nullable', 'string', 'regex:/^[a-zA-Z0-9_\/-]+$/', 'max:180'],
        ]);

        $timestamp = time();
        $parameters = [
            'timestamp' => $timestamp,
            'folder' => trim($data['folder'], '/'),
        ];

        if (! empty($data['public_id'])) {
            $parameters['public_id'] = trim($data['public_id'], '/');
        }

        $cloudName = (string) config('filesystems.disks.cloudinary.cloud_name');
        $apiKey = (string) config('filesystems.disks.cloudinary.api_key');
        $apiSecret = (string) config('filesystems.disks.cloudinary.api_secret');

        abort_if($cloudName === '' || $apiKey === '' || $apiSecret === '', 500, 'Cloudinary chưa được cấu hình.');

        return response()->json([
            'cloud_name' => $cloudName,
            'api_key' => $apiKey,
            'timestamp' => $timestamp,
            'signature' => ApiUtils::signParameters($parameters, $apiSecret),
            'folder' => $parameters['folder'],
            'public_id' => $parameters['public_id'] ?? null,
            'upload_url' => "https://api.cloudinary.com/v1_1/{$cloudName}/image/upload",
        ]);
    }
}
