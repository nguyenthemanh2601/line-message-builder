<?php

namespace ManhNt\Line\FlexMessage\Trait;

use ManhNt\Support\Str;
use UnexpectedValueException;
use ManhNt\Exception\UnexpectedTypeException;

trait MarginTrait
{
    /**
     * Margin. The minimum amount of space to include before this component in its parent container.
     *
     * @var string
     */
    protected $margin;

    /**
     * Return allowed margin values.
     *
     * @return string[]
     */
    public static function allowedMarginValues()
    {
        return [
            'sm', 'md', 'lg', 'xs', 'xl', 'xxl', 'none',
        ];
    }

    public function margin($margin)
    {
        if (!is_string($margin)) {
            throw new UnexpectedTypeException($margin, 'string');
        }

        $isNotCorrectStruct = !in_array($margin, static::allowedMarginValues())
            && (!Str::endsWith($margin, 'px')
                || !is_numeric(Str::before($margin, 'px'))
                || Str::before($margin, 'px') < "0"
            );

        if ($isNotCorrectStruct) {
            throw new UnexpectedValueException('Argument #1 ($margin) must be a positive integer or decimal number that ends in px. Examples include 50px and 23.5px');
        }

        $this->margin = $margin;

        return $this;
    }
}
