<?php

namespace ManhNt\Line\FlexMessage\Trait;

use UnexpectedValueException;

/**
 * @experimental
 *
 * This class can be modified in any way, or even removed, at any time.
 * Precautions when using it in production environments.
 * They are purely to allow broad testing and feedback.
 *
 * @author Nguyen The Manh <nguyenthemanh26011996@gmail.com>
 */
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
