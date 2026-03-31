<?php
$w = 1200;
$h = 630;
$img = imagecreatetruecolor($w, $h);

$bg = imagecolorallocate($img, 15, 23, 42);
imagefill($img, 0, 0, $bg);

$accent = imagecolorallocate($img, 59, 130, 246);
imagefilledrectangle($img, 0, 0, $w, 8, $accent);

$gold = imagecolorallocate($img, 255, 215, 0);
$cx = 600;
$cy = 220;
$r = 80;
for ($i = 0; $i < 12; $i++) {
    $angle = deg2rad($i * 30 - 90);
    $sx = $cx + cos($angle) * $r;
    $sy = $cy + sin($angle) * $r;
    imagefilledellipse($img, (int)$sx, (int)$sy, 12, 12, $gold);
}

$white = imagecolorallocate($img, 255, 255, 255);
$gray = imagecolorallocate($img, 148, 163, 184);

imagestring($img, 5, 420, 340, "EU VAT Info", $white);
imagestring($img, 4, 380, 370, "VAT Rates, Calculator & Tools", $gray);
imagestring($img, 3, 420, 400, "for all 27 EU Countries", $gray);

imagefilledrectangle($img, 0, $h - 4, $w, $h, $accent);
imagestring($img, 3, 520, 580, "eu-vat.info", $gray);

imagepng($img, __DIR__ . '/public/images/og-default.png', 9);
imagedestroy($img);
echo "Created 1200x630 OG image\n";
