<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class FaceRegistrationController extends Controller
{
    public function index()
    {
        return view('hris.hr-management.register-face');
    }

    public function store(Request $request)
    {
        $request->validate([
            'subject' => 'required|string',
            'image'   => 'required|array|min:1',
            'image.*' => 'required|string',
        ]);

        $subject = $request->input('subject');
        $responses = [];
        $savedPaths = [];

        $apiKey = config('services.compreface.recognition_api_key');
        $apiUrl = rtrim(config('services.compreface.url'), '/');

        if (!$apiKey || !$apiUrl) {
            return response()->json(['status' => 'error', 'message' => 'CompreFace not configured'], 500);
        }

        // 🔹 Step 1: Check if subject already exists
        $existing = Http::withHeaders([
            'x-api-key' => $apiKey,
        ])->get($apiUrl . '/api/v1/recognition/faces?subject=' . urlencode($subject));

        if ($existing->ok() && !empty($existing['faces'])) {
            foreach ($existing['faces'] as $face) {
                if (isset($face['image_id'])) {
                    Http::withHeaders([
                        'x-api-key' => $apiKey,
                    ])->delete($apiUrl . '/api/v1/recognition/faces/' . $face['image_id']);
                }
            }
        }

        // 🔹 Step 2: Register new images
        foreach ($request->input('image') as $imageData) {
            $image = preg_replace('/^data:image\/\w+;base64,/', '', $imageData);
            $image = str_replace(' ', '+', $image);

            $imageName = 'face_' . time() . '_' . uniqid() . '.jpg';
            $dir = public_path('faces');
            $path = $dir . '/' . $imageName;

            if (!file_exists($dir)) {
                mkdir($dir, 0777, true);
            }

            file_put_contents($path, base64_decode($image));
            $savedPaths[] = $path;

            $response = Http::withHeaders([
                'x-api-key' => $apiKey,
            ])->attach('file', file_get_contents($path), $imageName)
                ->post($apiUrl . '/api/v1/recognition/faces', [
                    'subject' => $subject,
                ]);

            $responses[] = [
                'path' => $path,
                'compreface_response' => $response->json(),
            ];
        }

        return response()->json([
            'status'  => 'success',
            'subject' => $subject,
            'results' => $responses,
        ]);
    }





    public function detect(Request $request)
    {
        if (!$request->hasFile('file')) {
            return response()->json(['compreface_response' => ['message' => 'No file uploaded']], 400);
        }

        $file = $request->file('file');

        $client = new \GuzzleHttp\Client();
        $response = $client->post(env('COMPREFACE_URL') . '/api/v1/detection/detect', [
            'headers' => [
                'x-api-key' => env('COMPREFACE_RECOGNITION_API_KEY'),
            ],
            'multipart' => [
                [
                    'name'     => 'file',
                    'contents' => fopen($file->getPathname(), 'r'),
                    'filename' => $file->getClientOriginalName()
                ]
            ]
        ]);

        $result = json_decode($response->getBody()->getContents(), true);

        return response()->json(['compreface_response' => $result]);
    }
}
