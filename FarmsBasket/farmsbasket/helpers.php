<?php
// helpers.php
function esc(string $v): string { return htmlspecialchars($v, ENT_QUOTES, 'UTF-8'); }


function money(float $n): string {
// INR style; customize as needed
$fmt = numfmt_create('en_IN', NumberFormatter::CURRENCY);
return numfmt_format_currency($fmt, $n, 'INR');
}


function placeholder_img(string $text='Farm\'sBasket'): string {
$svg = '<svg xmlns="http://www.w3.org/2000/svg" width="600" height="400">'
. '<rect width="100%" height="100%" fill="#e5f2e9"/>'
. '<text x="50%" y="50%" dominant-baseline="middle" text-anchor="middle"'
. ' font-size="28" font-family="Inter,Arial" fill="#1b5e20">' . esc($text) . '</text>'
. '</svg>';
return 'data:image/svg+xml;base64,' . base64_encode($svg);
}