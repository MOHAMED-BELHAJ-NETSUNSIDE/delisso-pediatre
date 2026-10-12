<?php
declare(strict_types=1);

namespace App\Helpers;

final class Upload
{
    public static function saveImage(array $file, string $subdir, int $maxBytes = 2097152): string
    {
        if (($file['error'] ?? UPLOAD_ERR_NO_FILE) !== UPLOAD_ERR_OK) {
            throw new \RuntimeException('Upload invalide');
        }
        if (($file['size'] ?? 0) > $maxBytes) {
            throw new \RuntimeException('Fichier trop volumineux (max 2 Mo)');
        }

        $finfo = new \finfo(FILEINFO_MIME_TYPE);
        $mime = $finfo->file($file['tmp_name']);
        $allowed = ['image/jpeg' => 'jpg', 'image/png' => 'png', 'image/webp' => 'webp'];
        if (!isset($allowed[$mime])) {
            throw new \RuntimeException('Type image non autorisé');
        }

        $root = dirname(__DIR__, 2) . '/public/uploads/' . trim($subdir, '/');
        if (!is_dir($root) && !mkdir($root, 0755, true) && !is_dir($root)) {
            throw new \RuntimeException('Impossible de créer le dossier upload');
        }

        $name = bin2hex(random_bytes(16)) . '.' . $allowed[$mime];
        $dest = $root . '/' . $name;
        if (!move_uploaded_file($file['tmp_name'], $dest)) {
            throw new \RuntimeException('Échec enregistrement fichier');
        }

        return 'uploads/' . trim($subdir, '/') . '/' . $name;
    }
}
