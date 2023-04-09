<?php

require "vendor/autoload.php";
function cloneObject($object)
{
    return clone $object;
}

$image = new ManhNt\Line\FlexMessage\Component\Image;
$image->url('https://scdn.line-apps.com/n/channel_devcenter/img/fx/01_1_cafe.png');

echo($image);
echo "\n";
echo "\n";

$text = new ManhNt\Line\FlexMessage\Component\Text;
// $text->text('text')->wrap(true)->weight('bold')->size('xxl')->color('#ff0000')->decoration('underline')->style('italic')->flex(3)->action(
//     (new ManhNt\Line\FlexMessage\Component\Action\MessageAction)->text('action text')
// );
// echo($text);
// echo "\n";
// echo "\n";

$box = new ManhNt\Line\FlexMessage\Component\Box;
// $box->layout('horizontal')->addContent([$image, new ManhNt\Line\FlexMessage\Component\Separator, $text]);

// echo($box);
// echo "\n";
// echo "\n";

$message = new ManhNt\Line\FlexMessage\Bubble\Message;
// $message->hero($image)->header($box)->footer($box);

$separator = new ManhNt\Line\FlexMessage\Component\Separator;
$action = new ManhNt\Line\FlexMessage\Component\Action\MessageAction;


$message->hero($image->url('https://scdn.line-apps.com/n/channel_devcenter/img/fx/01_1_cafe.png')->size('full'));
$message->body->layout('vertical')->addContent(cloneObject($text)->text('予約内容')->size('sm')->color("#1DB446")->weight('bold'));
$message->body->addContent($separator->margin('xxl'));

$text = cloneObject($text)->text('予約番号：RE12345')->size('xs')->color("#000000")->flex(0)->wrap(true);
$horizontalBox = $box->layout('horizontal')->margin('md');

$message->body->addContent(cloneObject($horizontalBox)->addContent($text));
$message->body->addContent(cloneObject($horizontalBox)->addContent(cloneObject($text)->text("スタッフ：staff_name")));
$message->body->addContent(cloneObject($horizontalBox)->addContent(cloneObject($text)->text("メニュー：無し")));
$message->body->addContent(cloneObject($horizontalBox)->addContent(cloneObject($text)->text("オプション：無し")));
$message->body->addContent(cloneObject($horizontalBox)->addContent(cloneObject($text)->text("日付：" . date("Y年m月d日"))));
$message->body->addContent(cloneObject($horizontalBox)->addContent(cloneObject($text)->text("開始時間：" . date("H:i"))));
$message->body->addContent(cloneObject($horizontalBox)->addContent([
    cloneObject($text)->text("ご入室に必要な暗証番号：")->flex(50)->wrap(false),
    cloneObject($text)->text("1234")->weight('bold')->flex(33)->size('lg')->color('#ff0000')->weight('bold'),
]));
$message->body->addContent($separator);
$message->body->addContent(cloneObject($horizontalBox)->addContent(cloneObject($text)->text("courceDescription")->color('#000080')));

$message->footer(
    cloneObject($horizontalBox)->layout('vertical')->addContent(
        cloneObject($text)->text("予約が確定しました！")->color('#db7093')->action(
            $action->text("text label")->label('detail label')
        )
    )
);

$message->style->footer->separator(true);
// dd($message->toArray());

echo $message->toJson();

// echo($bubble);
echo "\n";
echo "\n";