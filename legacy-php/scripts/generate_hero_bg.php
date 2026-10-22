<?php
/**
 * Script untuk membuat gambar background panoramic hero dari kumpulan foto di folder gambar/
 */

$width = 1920;
$height = 800;

$canvas = imagecreatetruecolor($width, $height);

// Warna dasar gelap
$darkBg = imagecolorallocate($canvas, 4, 50, 40);
imagefill($canvas, 0, 0, $darkBg);

// Kita susun kolase foto panoramic yang kaya variasi:
// Grid 4 kolom x 2 baris atau susunan mosaic dinamis:
// Kolom 1 (kiri, x: 0 - 480):
//   - Atas (480x400): Tausiyah Ustadz Tata di Mihrab (foto-kegiatan.jpeg)
//   - Bawah (480x400): Yasinan & Tahlil Malam Jumat (foto-kegiatan-8.jpeg)
// Kolom 2 (tengah-kiri, x: 480 - 960):
//   - Atas (480x400): Suasana Sholat Berjamaah Khusyuk (foto-kegiatan-6.jpeg)
//   - Bawah (480x400): Selasar & Jamaah Musholla (foto-kegiatan-4.jpeg)
// Kolom 3 (tengah-kanan, x: 960 - 1440):
//   - Full Height / Menonjol (480x800): Jamaah Akbar di Pelataran Teras (foto-kegiatan-11.jpeg)
// Kolom 4 (kanan, x: 1440 - 1920):
//   - Atas (480x400): Tim Hadroh & Remaja Musholla (foto-kegiatan-10.jpeg)
//   - Bawah (480x400): Fasad Tampak Depan Musholla Ar-rahman (foto-kegiatan-7.jpeg)

$rootPath = dirname(__DIR__);
$tiles = [
    // [filename, dx, dy, dw, dh]
    ['foto-kegiatan.jpeg', 0, 0, 480, 400],
    ['foto-kegiatan-8.jpeg', 0, 400, 480, 400],
    
    ['foto-kegiatan-6.jpeg', 480, 0, 480, 400],
    ['foto-kegiatan-2.jpeg', 480, 400, 480, 400],
    
    ['foto-kegiatan-11.jpeg', 960, 0, 480, 800],
    
    ['foto-kegiatan-10.jpeg', 1440, 0, 480, 410],
    ['foto-kegiatan-7.jpeg', 1440, 410, 480, 390],
];

foreach ($tiles as $tile) {
    list($file, $dx, $dy, $dw, $dh) = $tile;
    $filePath = $rootPath . '/public/uploads/' . $file;
    if (!file_exists($filePath)) continue;

    $src = @imagecreatefromjpeg($filePath);
    if (!$src) continue;

    $sw = imagesx($src);
    $sh = imagesy($src);

    $srcRatio = $sw / $sh;
    $destRatio = $dw / $dh;

    if ($srcRatio > $destRatio) {
        $tempH = $sh;
        $tempW = (int)($sh * $destRatio);
        $srcX = (int)(($sw - $tempW) / 2);
        $srcY = 0;
    } else {
        $tempW = $sw;
        $tempH = (int)($sw / $destRatio);
        $srcX = 0;
        $srcY = (int)(($sh - $tempH) / 2);
    }

    imagecopyresampled($canvas, $src, $dx, $dy, $srcX, $srcY, $dw, $dh, $tempW, $tempH);
    imagedestroy($src);
}

// Simpan gambar background kolase
$outDir = $rootPath . '/public/assets/images';
if (!is_dir($outDir)) {
    mkdir($outDir, 0755, true);
}
$outFile = $outDir . '/hero-bg-collage.jpg';
imagejpeg($canvas, $outFile, 90);

copy($outFile, $rootPath . '/public/uploads/hero-bg-collage.jpg');

imagedestroy($canvas);
echo "Hero background collage created successfully: " . $outFile . " (" . filesize($outFile) . " bytes)\n";
