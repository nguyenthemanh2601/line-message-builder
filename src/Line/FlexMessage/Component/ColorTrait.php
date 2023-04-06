<?php

namespace ManhNt\Line\FlexMessage\Component;

use UnexpectedValueException;

trait ColorTrait
{
    /**
     * Font color
     *
     * @var string
     */
    protected $color;

    /**
     * Set font color
     *
     * @param  string  $color
     * @return $this
     */
    public function color($color)
    {
        if (!preg_match('/^#([A-Fa-f0-9]{6})$/', $color)) {
            throw new UnexpectedValueException('Argument #1 ($color) must be a valid hexadecimal color code');
        }

        $this->color = $color;

        return $this;
    }
}
