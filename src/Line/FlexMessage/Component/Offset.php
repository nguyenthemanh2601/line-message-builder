<?php

namespace ManhNt\Line\FlexMessage\Component;

use UnexpectedValueException;
use ManhNt\Support\Str;
use ManhNt\Exception\UnexpectedTypeException;
use ManhNt\Line\Contract\BoxContent;

class Offset extends BoxContent
{
    const ALLOWED_FONT_SIZE = ['sm', 'md', 'lg', 'xs', 'xl', 'xxl'];

    protected $offsetTop;
    protected $offsetBottom;
    protected $offsetStart;
    protected $offsetEnd;

    public function __construct($offsetTop = null, $offsetBottom = null, $offsetStart = null, $offsetEnd = null)
    {
        $this->offsetTop = $offsetTop;
        $this->offsetBottom = $offsetBottom;
        $this->offsetStart = $offsetStart;
        $this->offsetEnd = $offsetEnd;
    }

    public static function factory($offsetTop = null, $offsetBottom = null, $offsetStart = null, $offsetEnd = null)
    {
        return new static($offsetTop, $offsetBottom, $offsetStart, $offsetEnd);
    }

    public function top($value)
    {
        $this->validate($value);
        $this->offsetTop = $value;

        return $this;
    }

    public function bottom($value)
    {
        $this->validate($value);
        $this->offsetBottom = $value;

        return $this;
    }

    public function start($value)
    {
        $this->validate($value);
        $this->offsetStart = $value;

        return $this;
    }

    public function end($value)
    {
        $this->validate($value);
        $this->offsetEnd = $value;

        return $this;
    }

    public function toArray()
    {
        return array_filter(get_object_vars($this));
    }

    public function toJson($options = 0)
    {
        return json_encode($this->toArray(), $options);
    }

    public function __toString()
    {
        try {
            return $this->toJson();
        } catch (\Exception $e) {
            return var_export($e, true);
        }
    }

    protected function validate($value)
    {
        if (!is_string($value)) {
            throw new UnexpectedTypeException($value, 'string');
        }

        $isNotValidSize = !in_array($value, static::ALLOWED_FONT_SIZE)
            && (!Str::endsWith($value, 'px')
                || !is_numeric(Str::before($value, 'px'))
                || Str::before($value, 'px') < "0");

        if ($isNotValidSize) {
            throw new UnexpectedValueException('Argument #1 ($size) must be a positive integer or decimal number that ends in px. Examples include 50px and 23.5px');
        }
    }
}
