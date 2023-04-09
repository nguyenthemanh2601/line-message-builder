<?php

namespace ManhNt\Line\FlexMessage\Bubble;

use ManhNt\Support\Container;
use ManhNt\Contract\ArrayAble;
use ManhNt\Line\FlexMessage\Component\Box;
use ManhNt\Line\FlexMessage\Component\Image;
use ManhNt\Exception\UnexpectedTypeException;
use Core\Service\Line\FlexMessage\Enum\Direction;
use Core\Service\Line\FlexMessage\Enum\BubbleSize;

class Message implements ArrayAble
{
    const TYPE = 'bubble';

    /** @var \ManhNt\Line\FlexMessage\Component\Box */
    public $body;

    /** @var \ManhNt\Line\FlexMessage\Bubble\Style */
    public $style;

    protected $size;
    protected $direction;
    protected $header;
    protected $hero;
    protected $footer;

    public function __construct(Box $body = null, Style $style = null)
    {
        $this->initialize($body, $style);
    }

    private function initialize(Box $body = null, Style $style = null)
    {
        $this->body = $body;
        $this->style = $style;
        if (!$this->body) {
            $this->body = Container::getInstance()->make(Box::class);
        }
        if (!$this->style) {
            $this->style = Container::getInstance()->make(Style::class);
        }
    }

    public function hero($hero = null)
    {
        $allowedTypes = [Box::class, Image::class];

        if ("object" != gettype($hero) && !in_array(get_class($hero), $allowedTypes)) {
            throw new UnexpectedTypeException($hero, implode("|", $allowedTypes));
        }

        if (func_num_args()) {
            $this->hero = $hero;
        }

        return $this;
    }

    public function header(Box $header = null)
    {
        if (func_num_args()) {
            $this->header = $header;
        }

        return $this;
    }

    public function footer(Box $footer = null)
    {
        if (func_num_args()) {
            $this->footer = $footer;
        }

        return $this;
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

    public function __toString()
    {
        return $this->toJson();
    }

    public function toArray()
    {
        $value =  array_merge(["type" => self::TYPE], get_object_vars($this));

        foreach ($value as $k => $v) {
            if ($v instanceof ArrayAble) {
                $value[$k] = $v->toArray();
            }
        }

        return array_filter($value);
    }
}
