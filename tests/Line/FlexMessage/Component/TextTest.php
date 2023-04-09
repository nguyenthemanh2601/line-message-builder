<?php

namespace Tests\Line\FlexMessage\Component;

use PHPUnit\Framework\TestCase;
use ManhNt\Line\FlexMessage\Component\Text;
use ManhNt\Exception\UnexpectedTypeException;
use ManhNt\Line\FlexMessage\Component\Action\MessageAction;

class TextTest extends TestCase
{
    /** @var \ManhNt\Line\FlexMessage\Component\Text */
    private $text;

    public function __construct()
    {
        $this->text = new Text;
    }

    public function testHeroReturnTextInstance()
    {
        $this->assertInstanceOf(Text::class, $this->text->text('Text'));
    }

    public function testHeroThrowUnexpectedTypeException()
    {
        $this->expectException(UnexpectedTypeException::class);
        $this->text->text(1);
    }

    public function testHeroThrowUnexpectedValueException()
    {
        $this->expectException(\UnexpectedValueException::class);
        $this->text->text('');
    }

    public function testSizeReturnTextInstance()
    {
        $this->assertInstanceOf(Text::class, $this->text->size('1px'));
    }

    public function testSizeThrowUnexpectedTypeException()
    {
        $this->expectException(UnexpectedTypeException::class);
        $this->text->size(1);
    }

    public function testSizeThrowUnexpectedValueException()
    {
        $this->expectException(\UnexpectedValueException::class);
        $this->text->size('');
    }

    public function testWeightReturnTextInstance()
    {
        $this->assertInstanceOf(Text::class, $this->text->weight('bold'));
    }

    public function testWeightThrowUnexpectedTypeException()
    {
        $this->expectException(UnexpectedTypeException::class);
        $this->text->weight(true);
    }

    public function testWeightThrowUnexpectedValueException()
    {
        $this->expectException(\UnexpectedValueException::class);
        $this->text->weight('none');
    }

    public function testStyleReturnTextInstance()
    {
        $this->assertInstanceOf(Text::class, $this->text->style('normal'));
    }

    public function testStyleThrowUnexpectedTypeException()
    {
        $this->expectException(UnexpectedTypeException::class);
        $this->text->style(true);
    }

    public function testStyleThrowUnexpectedValueException()
    {
        $this->expectException(\UnexpectedValueException::class);
        $this->text->style('none');
    }

    public function testDecorationReturnTextInstance()
    {
        $this->assertInstanceOf(Text::class, $this->text->decoration('none'));
        $this->assertInstanceOf(Text::class, $this->text->decoration('underline'));
        $this->assertInstanceOf(Text::class, $this->text->decoration('line-through'));
    }

    public function testDecorationThrowUnexpectedTypeException()
    {
        $this->expectException(UnexpectedTypeException::class);
        $this->text->decoration(1);
    }

    public function testDecorationThrowUnexpectedValueException()
    {
        $this->expectException(\UnexpectedValueException::class);
        $this->text->decoration('regular');
    }

    public function testActionReturnTextInstance()
    {
        $this->assertInstanceOf(Text::class, $this->text->action(new MessageAction));
    }

    public function testActionThrowUnexpectedTypeException()
    {
        $action = new MessageAction;
        $this->expectException(\PHPUnit_Framework_Error::class);
        $this->text->action(1);
    }

    public function testWrapReturnTextInstance()
    {
        $this->assertInstanceOf(Text::class, $this->text->wrap(true));
        $this->assertInstanceOf(Text::class, $this->text->wrap(false));
    }

    public function testWrapThrowUnexpectedTypeException()
    {
        $this->expectException(UnexpectedTypeException::class);
        $this->text->wrap(1);
        $this->text->wrap('');
        $this->text->wrap(null);
    }

    /**
     * @param \ManhNt\Line\FlexMessage\Component\Text $textInstance
     * @param array $expectedArray
     *
     * @dataProvider convertToArrayProvider
     */
    public function testConvertToArray($textInstance, $expectedArray)
    {
        $this->assertEquals($expectedArray, $textInstance->toArray());
    }

    public function convertToArrayProvider()
    {
        return [
            [
                $this->text->text('test text')->wrap(true)->flex(5)->action(
                    (new MessageAction)->text('action text')
                ), [
                    'type' => 'text',
                    'text' => 'test text',
                    'wrap' => true,
                    'flex' => 5,
                    'action' => [
                        'type' => "message",
                        'text' => "action text",
                    ],
                ]
            ],
        ];
    }

    /**
     * @depends testConvertToArray
     */
    public function testConvertToJson($textInstance, $expectedJson)
    {
        $this->assertEquals($expectedJson, $textInstance->toJson());
    }

    public function convertToJsonProvider()
    {
        $providers = [];
        foreach ($providers as $key => $provider) {
            $providers[$key][1] = json_encode($provider[1]);
        }

        return $providers;
    }
}
