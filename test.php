<?php

require "vendor/autoload.php";

$image = new ManhNt\Line\FlexMessage\Component\Image;
$image->url('https://scdn.line-apps.com/n/channel_devcenter/img/fx/01_1_cafe.png');

echo($image);