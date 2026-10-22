<?php
/**
 * File Uploader with Security Validation
 */

class Uploader {
    public static function uploadImage(array $file, string $prefix = 'img'): ?string {
        if (!isset($file['error']) || is_array($file['error'])) {
            Session::setFlash('error', 'Parameter file tidak valid.');
            return null;
        }

        switch ($file['error']) {
            case UPLOAD_ERR_OK:
                break;
            case UPLOAD_ERR_NO_FILE:
                return null; // Tidak ada file yang diunggah
            case UPLOAD_ERR_INI_SIZE:
            case UPLOAD_ERR_FORM_SIZE:
                Session::setFlash('error', 'Ukuran file melebihi batas yang diizinkan (maksimal 8MB).');
                return null;
            default:
                Session::setFlash('error', 'Terjadi kesalahan saat mengunggah file.');
                return null;
        }

        // Cek ukuran
        if ($file['size'] > MAX_UPLOAD_SIZE) {
            Session::setFlash('error', 'Ukuran file terlalu besar (maksimal 8MB).');
            return null;
        }

        // Cek MIME type dengan finfo
        $finfo = new finfo(FILEINFO_MIME_TYPE);
        $mimeType = $finfo->file($file['tmp_name']);

        if (!in_array($mimeType, ALLOWED_IMAGE_TYPES, true)) {
            Session::setFlash('error', 'Format file tidak diizinkan. Hanya format JPG, PNG, WEBP, atau GIF yang diperbolehkan.');
            return null;
        }

        // Tentukan ekstensi yang aman
        $extensions = [
            'image/jpeg' => 'jpg',
            'image/png'  => 'png',
            'image/webp' => 'webp',
            'image/gif'  => 'gif',
        ];
        $ext = $extensions[$mimeType] ?? 'jpg';

        // Buat nama file unik yang acak
        $filename = sprintf('%s_%s_%s.%s', $prefix, date('Ymd_His'), bin2hex(random_bytes(6)), $ext);

        // Pastikan folder uploads tersedia
        if (!is_dir(UPLOAD_DIR)) {
            mkdir(UPLOAD_DIR, 0755, true);
        }

        $destination = UPLOAD_DIR . '/' . $filename;
        if (!move_uploaded_file($file['tmp_name'], $destination)) {
            Session::setFlash('error', 'Gagal memindahkan file yang diunggah.');
            return null;
        }

        return $filename;
    }

    public static function deleteFile(?string $filename): bool {
        if (empty($filename)) return false;
        $path = UPLOAD_DIR . '/' . basename($filename);
        if (file_exists($path)) {
            return @unlink($path);
        }
        return false;
    }
}
