<?php

namespace ManhNt\Line\FlexMessage\Component;

use UnexpectedValueException;
use ManhNt\Line\Contract\BoxContent;
use ManhNt\Exception\UnexpectedTypeException;
use ManhNt\Line\FlexMessage\Trait\ColorTrait;
use ManhNt\Line\FlexMessage\Trait\FontWeightTrait;

/**
 * @experimental
 *
 * This class can be modified in any way, or even removed, at any time.
 * Precautions when using it in production environments.
 * They are purely to allow broad testing and feedback.
 *
 * @author Nguyen The Manh <nguyenthemanh26011996@gmail.com>
 */

class Span extends BoxContent
{
    use ColorTrait, FontWeightTrait;

    const ALLOWED_STYLES = ['normal', 'italic'];

    const ALLOWED_DECORATION = ['none', 'underline', 'line-through'];

    protected $type = 'span';

    /** @var string */
    protected $text;

    /** @var string */
    protected $style;

    /**
     * @return $this
     */
    public static function factory()
    {
        return new static;
    }

    /**
     * Set text
     *
     * @param  string  $value
     * @return $this
     * @throws \ManhNt\Exception\UnexpectedTypeException
     */
    public function text($value)
    {
        if (!is_scalar($value)) {
            throw new UnexpectedTypeException($value, 'string');
        }

        $this->text = $value;

        return $this;
    }

    /**
     * Set style
     *
     * @param  string  $value
     * @return $this
     * @throws \UnexpectedValueException
     */
    public function style($value)
    {
        if (!in_array($value, static::ALLOWED_STYLES)) {
            throw new UnexpectedValueException(
                sprintf(
                    'Argument #1 ($value) must be one of the following values: %s',
                    implode(", ", static::ALLOWED_STYLES)
                )
            );
        }

        $this->style = $value;

        return $this;
    }

    /**
     * Set style
     *
     * @param  string  $value
     * @return $this
     * @throws \UnexpectedValueException
     */
    public function weight($value)
    {
        if (!in_array($value, static::ALLOWED_STYLES)) {
            throw new UnexpectedValueException(
                sprintf(
                    'Argument #1 ($value) must be one of the following values: %s',
                    implode(", ", static::ALLOWED_STYLES)
                )
            );
        }

        $this->style = $value;

        return $this;
    }

    /**
     * Set decoration
     *
     * @param  string  $value
     * @return $this
     * @throws \UnexpectedValueException
     */
    public function decoration($value)
    {
        if (!in_array($value, static::ALLOWED_DECORATION)) {
            throw new UnexpectedValueException(
                sprintf(
                    'Argument #1 ($value) must be one of the following values: %s',
                    implode(", ", static::ALLOWED_DECORATION)
                )
            );
        }

        $this->style = $value;

        return $this;
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
            return var_export($e) ?: '';
        }
    }

    public function toArray()
    {
        return array_filter(get_object_vars($this));
    }
}
