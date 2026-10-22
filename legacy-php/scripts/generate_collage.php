<?php
/**
 * Script untuk membuat gambar gabungan (collage) foto kegiatan Musholla Ar-rahman
 */

$width = 1200;
$height = 800;

$collage = imagecreatetruecolor($width, $height);

// Warna background bernuansa emerald islami
$bgColor = imagecolorallocate($collage, 7, 91, 74);
$goldColor = imagecolorallocate($collage, 212, 175, 55);
$whiteColor = imagecolorallocate($collage, 255, 255, 255);
$darkGreen = imagecolorallocate($collage, 5, 62, 50);

imagefill($collage, 0, 0, $bgColor);

// Daftar foto yang akan digabungkan
$photos = [
    // [file, dest_x, dest_y, dest_w, dest_h]
    // 1. Kiri atas (Besar): Jamaah Pengajian & Sholat Akbar di Teras
    ['foto-kegiatan-11.jpeg', 20, 20, 680, 420],
    
    // 2. Kiri bawah: Tausiyah Ustadz Tata A.S di Mihrab
    ['foto-kegiatan.jpeg', 20, 460, 330, 320],
    
    // 3. Tengah bawah: Sholat Berjamaah Khusyuk Warga
    ['foto-kegiatan-5.jpeg', 370, 460, 330, 320],
    
    // 4. Kanan atas: Tim Hadroh & Remaja Musholla Santri
    ['foto-kegiatan-10.jpeg', 720, 20, 460, 440],
    
    // 5. Kanan bawah: Tampak Depan Musholla Ar-rahman
    ['foto-kegiatan-7.jpeg', 720, 480, 460, 300],
];

foreach ($photos as $item) {
    list($filename, $dx, $dy, $dw, $dh) = $item;
    $filePath = __DIR__ . '/public/uploads/' . $filename;
    if (!file_exists($filePath)) continue;

    $src = @imagecreatefromjpeg($filePath);
    if (!$src) continue;

    $sw = imagesx($src);
    $sh = imagesy($src);

    // Hitung crop center cover
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

    // Border emas tipis di sekeliling frame foto
    imagefilledrectangle($collage, $dx - 4, $dy - 4, $dx + $dw + 4, $dy + $dh + 4, $goldColor);

    // Copy gambar hasil resample
    imagecopyresampled($collage, $src, $dx, $dy, $srcX, $srcY, $dw, $dh, $tempW, $tempH);

    imagedestroy($src);
}

// Simpan output ke public/uploads/hero-collage-kegiatan.jpeg
$outPath = __DIR__ . '/public/uploads/hero-collage-kegiatan.jpeg';
imagejpeg($collage, $outPath, 92);
imagedestroy($collage);

echo "Collage created successfully at: " . $outPath . " (" . filesize($outPath) . " bytes)\n";
