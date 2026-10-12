<?php

namespace App\Http\Controllers;

use Symfony\Component\HttpFoundation\BinaryFileResponse;

class PublicMediaController extends Controller
{
    public function show(string $path): BinaryFileResponse
    {
        $relative = ltrim(str_replace('\\', '/', $path), '/');
        if ($relative === '' || str_contains($relative, '..')) {
            abort(404);
        }

        $root = realpath(storage_path('app/public'));
        $real = realpath(storage_path('app/public/'.$relative));
        $rootPrefix = $root === false ? '' : rtrim($root, DIRECTORY_SEPARATOR).DIRECTORY_SEPARATOR;

        if ($root === false || $real === false || ! is_file($real) || ! str_starts_with($real, $rootPrefix)) {
            abort(404);
        }

        return response()->file($real, [
            'Cache-Control' => 'public, max-age=604800',
        ]);
    }
}
