<?php

namespace ManhNt\Line\FlexMessage\Component;

use UnexpectedValueException;
use ManhNt\Support\Str;
use ManhNt\Exception\UnexpectedTypeException;
use ManhNt\Line\Contract\BoxContent;

class Padding extends BoxContent
{
    /**
     * Free space between the borders of this box and the child element.
     *
     * @var string
     */
    protected $all;

    /**
     * Free space between the border at the upper end of this box and the upper end of the child element.
     *
     * @var string
     */
    protected $top;

    /**
     * Free space between the border at the lower end of this box and the lower end of the child element.
     *
     * @var string
     */
    protected $bottom;

    /**
     * If the text directionality in the bubble is LTR: Free space between the border at the left end of this box and the left end of the child element.
     * If the text directionality in the bubble is RTL: Free space between the border at the right end of this box and the right end of the child element
     *
     * @var string
     */
    protected $start;

    /**
     * If the text directionality in the bubble is LTR: Free space between the border at the right end of this box and the right end of the child element.
     * If the text directionality in the bubble is RTL: Free space between the border at the left end of this box and the left end of the child element
     *
     * @var string
     */
    protected $end;

    public function __construct(array $options = [])
    {
        foreach (get_object_vars($this) as $property => $value) {
            if (isset($options[$property])) {
                $this->$property($options[$property]);
            }
        }
    }

    public static function factory(array $options = [])
    {
        return new static($options);
    }

    /**
     * Set offset all
     *
     * @param string $value
     * @return $this
     * @throws \UnexpectedValueException
     */
    public function all($value)
    {
        $this->validate($value);
        $this->all = $value;

        return $this;
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
            $value["padding" . Str::upper($k)] = $v;
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

    /**
     * Validate value
     *
     * @param string $value
     * @throws \ManhNt\Exception\UnexpectedTypeException|\UnexpectedValueException
     * @return void
     */
    protected function validate($value)
    {
        if (!is_string($value)) {
            throw new UnexpectedTypeException($value, 'string');
        }

        $isInValidValue = !in_array($value, static::ALLOWED_VALUE)
            && !preg_match("/^[1-9][0-9]*%$/", $value)
            && !!preg_match("/^[1-9][0-9]*px$/", $value);

        if ($isInValidValue) {
            throw new UnexpectedValueException('Argument #1 ($value) is incorrect format');
        }
    }
}
