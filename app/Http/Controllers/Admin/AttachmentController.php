<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attachment;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class AttachmentController extends Controller
{
    private $fileTypes = [
        'image' => [
            'max' => 3072,
            'mimes' => 'jpg,jpeg,png,gif,webp',
        ],
        'file' => [
            'max' => 10240,
            'mimes' => 'pdf,doc,docx,xls,xlsx',
        ],
    ];

    public function upload(Request $request, string $folder): JsonResponse
    {
        $validationRules = [];
        $uploadedFiles = [];

        foreach ($this->fileTypes as $type => $rules) {
            if ($request->hasFile($type)) {
                $validationRules[$type] = 'required';
                $typeRules = "file|max:{$rules['max']}|mimes:{$rules['mimes']}";

                if (is_array($request->file($type))) {
                    $validationRules[$type] .= '|array';
                    $validationRules["{$type}.*"] = $typeRules;
                } else {
                    $validationRules[$type] .= '|'.$typeRules;
                }

                $uploadedFiles = array_merge(
                    $uploadedFiles,
                    $this->processFiles($request->file($type), $folder, $type)
                );
            }
        }

        if (empty($validationRules)) {
            return response()->json([
                'success' => false,
                'message' => 'No files were uploaded',
            ], 400);
        }

        $validator = Validator::make($request->all(), $validationRules);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        return response()->json([
            'success' => true,
            'files' => $uploadedFiles,
        ]);
    }

    private function processFiles($files, string $folder, string $type): array
    {
        $files = is_array($files) ? $files : [$files];

        return collect($files)->map(function ($file) use ($folder, $type) {
            $originalName = $file->getClientOriginalName();
            $extension = $file->getClientOriginalExtension();
            $randName = Str::uuid();
            $date = now()->format('Y-m-d');

            $path = $file->storeAs("{$folder}/{$date}", $randName.'.'.$extension, 'public');

            $attachment = Attachment::create([
                'filename' => $randName,
                'extension' => $extension,
                'size' => $file->getSize(),
                'title' => $type,
            ]);

            return [
                'id' => $attachment->id,
                'name' => $originalName,
                'extension' => $extension,
                'path' => $path,
            ];
        })->toArray();
    }
}
