<?php

session_start();

$captcha = substr(str_shuffle(
    "ABCDEFGHJKLMNPQRSTUVWXYZ23456789"
), 0, 6);


// storing captcha in session
$_SESSION['captcha'] = $captcha;

$image = imagecreate(150, 50);

$bg = imagecolorallocate($image, 255, 255, 255);
$text = imagecolorallocate($image, 0, 0, 0);

// Random lines
for($i = 0; $i < 8; $i++)
{
    $lineColor = imagecolorallocate(
        $image,
        rand(100, 200),
        rand(100, 200),
        rand(100, 200)
    );

    imageline(
        $image,
        rand(0, 150),
        rand(0, 50),
        rand(0, 150),
        rand(0, 50),
        $lineColor
    );
}

imagestring(
    $image,
    5,
    35,
    15,
    $captcha,
    $text
);

header("Content-Type: image/png");

imagepng($image);

imagedestroy($image);

?>