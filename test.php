<?php

require "vendor/autoload.php";

$image = new ManhNt\Line\FlexMessage\Component\Image;
$image->url('https://scdn.line-apps.com/n/channel_devcenter/img/fx/01_1_cafe.png');

echo($image);
echo "\n";
echo "\n";

$text = new ManhNt\Line\FlexMessage\Component\Text;
$text->text('text')->wrap(true)->weight('bold')->size('xxl')->color('#ff0000')->decoration('underline')->style('italic')->flex(3)->action(
    (new ManhNt\Line\FlexMessage\Component\Action\MessageAction)->text('action text')
);
echo($text);
echo "\n";
echo "\n";