<?php

namespace ManhNt\Line\FlexMessage\Trait;

use UnexpectedValueException;
use ManhNt\Exception\UnexpectedTypeException;

/**
 * @experimental
 *
 * This class can be modified in any way, or even removed, at any time.
 * Precautions when using it in production environments.
 * They are purely to allow broad testing and feedback.
 *
 * @author Nguyen The Manh <nguyenthemanh26011996@gmail.com>
 */
trait FontWeightTrait
{
    /** @var string */
    protected $weight;

    /**
     * Set font weight
     *
     * @param  string  $weight
     * @return $this
     */
    public function weight($weight)
    {
        if (!is_string($weight)) {
            throw new UnexpectedTypeException($weight, 'string');
        }

        if (!in_array($weight, static::allowedFontWeight())) {
            throw new UnexpectedValueException(
                sprintf(
                    'Argument #1 ($weight) must be one of the following values: %s',
                    implode(", ", static::allowedFontWeight())
                )
            );
        }

        $this->weight = $weight;

        return $this;
    }

    /**
     * Return allowed font weight
     *
     * @return array
     */
    protected static function allowedFontWeight()
    {
        return ['bold', 'regular'];
    }
}
