<?php

namespace ManhNt\Line\FlexMessage\Bubble;

use ManhNt\Contract\ArrayAble;
use ManhNt\Line\FlexMessage\Component\Box;
use Core\Service\Line\FlexMessage\Enum\Direction;
use Core\Service\Line\FlexMessage\Enum\BubbleSize;
use ManhNt\Line\FlexMessage\Component\Image;

class Message implements ArrayAble
{
    protected const TYPE = 'bubble';

    protected $size;
    protected $direction;
    protected $header;
    protected $hero;
    protected $body;
    protected $footer;
    protected $style;

    public function __construct(Box $body, Style $style)
    {
        $this->body = $body;
        $this->style = $style;
    }

    public function hero(Box|Image $hero = null)
    {
        if (func_num_args()) {
            $this->hero = $hero;

            return $this;
        }

        return $this->hero ?? $this->hero = app()->make(Box::class);
    }

    public function header(Box $header = null)
    {
        if (func_num_args()) {
            $this->header = $header;

            return $this;
        }

        return $this->header ?? $this->header = app()->make(Box::class);
    }

    public function footer(Box $footer = null)
    {
        if (func_num_args()) {
            $this->footer = $footer;

            return $this;
        }

        return $this->footer ?? $this->footer = app()->make(Box::class);
    }

    public function size(BubbleSize $size)
    {
        $this->size = $size;

        return $this;
    }

    public function direction(Direction $direction)
    {
        $this->direction = $direction;

        return $this;
    }

    public function toJson()
    {
        return json_encode($this->toArray());
    }

    public function __toString(): string
    {
        return $this->toJson();
    }

    public function toArray(): array
    {
        $value = [
            'type' => self::TYPE,
            'size' => $this->size,
            'body' => $this->body->toArray(),
            'styles' => $this->style->toArray(),
        ];

        foreach (['header', 'hero', 'footer'] as $property) {
            if (isset($this->{$property})) {
                $value[$property] = $this->{$property}->toArray();
            }
        }

        return array_filter($value, function($v) { return !empty($v);});
    }
}
