<?php

namespace ManhNt\Line\FlexMessage\Component;

use UnexpectedValueException;
use ManhNt\Support\Str;
use ManhNt\Exception\UnexpectedTypeException;
use ManhNt\Line\Contract\BoxContent;

class Offset extends BoxContent
{
    const ALLOWED_VALUE = ['sm', 'md', 'lg', 'xs', 'xl', 'xxl'];

    /**
     * Shifts the component down from the top edge of the component's original position.
     *
     * @var string
     */
    protected $top;

    /**
     * Shifts the component up from the bottom edge of the component's original position.
     *
     * @var string
     */
    protected $bottom;

    /**
     * Shifts the component away from the where the text starts.
     * If the bubble's text direction is LTR, shift is to the right. If RTL, shift is to the left.
     *
     * @var string
     */
    protected $start;

    /**
     * Away from the where the text ends. If the bubble's text direction is LTR, shift is to the left.
     * If RTL, shift is to the right.
     *
     * @var string
     */
    protected $end;

    public function __construct($top = null, $bottom = null, $start = null, $end = null)
    {
        $this->top = $top;
        $this->bottom = $bottom;
        $this->start = $start;
        $this->end = $end;
    }

    public static function factory($offsetTop = null, $bottom = null, $start = null, $end = null)
    {
        return new static($offsetTop, $bottom, $start, $end);
    }

    /**
     * Set offset top
     *
     * @param string $value
     * @return $this
     * @throws \UnexpectedValueException
     */
    public function top($value)
    {
        $this->validate($value);
        $this->top = $value;

        return $this;
    }

    /**
     * Set offset bottom
     *
     * @param string $value
     * @return $this
     * @throws \UnexpectedValueException
     */
    public function bottom($value)
    {
        $this->validate($value);
        $this->bottom = $value;

        return $this;
    }

    /**
     * Set offset start
     *
     * @param string $value
     * @return $this
     * @throws \UnexpectedValueException
     */
    public function start($value)
    {
        $this->validate($value);
        $this->start = $value;

        return $this;
    }

    /**
     * Set offset end
     *
     * @param string $value
     * @return $this
     * @throws \UnexpectedValueException
     */    public function end($value)
    {
        $this->validate($value);
        $this->end = $value;

        return $this;
    }

    public function toArray()
    {
        $value = array_filter(get_object_vars($this));
        foreach ($value as $k => $v) {
            $value["offset" . Str::upper($k)] = $v;
            unset($value[$k]);
        }

        return $value;
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

        $isNotValidSize = !in_array($value, static::ALLOWED_VALUE)
            && (!Str::endsWith($value, 'px')
                || !is_numeric(Str::before($value, 'px'))
                || Str::before($value, 'px') < "0");

        if ($isNotValidSize) {
            throw new UnexpectedValueException('Argument #1 ($size) must be a positive integer or decimal number that ends in px. Examples include 50px and 23.5px');
        }
    }
}
