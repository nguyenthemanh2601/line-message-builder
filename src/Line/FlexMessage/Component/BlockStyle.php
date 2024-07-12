<?php

namespace ManhNt\Line\FlexMessage\Component;

use ManhNt\Contract\ArrayAble;
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
class BlockStyle implements ArrayAble
{
    protected $separator = false;

    /**
     * Background color of the block
     *
     * @var string
     */
    protected $backgroundColor;

    /**
     * Color of the separator.
     *
     * @var string
     */
    protected $separatorColor;

    /**
     * @return $this
     */
    public static function factory()
    {
        return new static;
    }

    /**
     * Show separator
     *
     * @param  bool  $show
     * @return $this
     */
    public function separator($show)
    {
        if (!is_bool($show)) {
            throw new UnexpectedTypeException($show, 'bool');
        }

        $this->separator = $show;

        return $this;
    }

    /**
     * Set font color
     *
     * @param  string  $color
     * @return $this
     */
    public function backgroundColor($backgroundColor)
    {
        if (!is_string($backgroundColor)) {
            throw new UnexpectedTypeException($backgroundColor, 'string');
        }

        if (!preg_match('/^#([A-Fa-f0-9]{6})$/', $backgroundColor)) {
            throw new UnexpectedValueException(
                sprintf(
                    '%s Argument #1 ($backgroundColor) must be a valid hexadecimal color code',
                    __METHOD__
                )
            );
        }

        $this->backgroundColor = $backgroundColor;

        return $this;
    }

    /**
     * Set font color
     *
     * @param  string  $color
     * @return $this
     */
    public function separatorColor($separatorColor)
    {
        if (!is_string($separatorColor)) {
            throw new UnexpectedTypeException($separatorColor, 'string');
        }

        if (!preg_match('/^#([A-Fa-f0-9]{6})$/', $separatorColor)) {
            throw new UnexpectedValueException(
                sprintf(
                    '%s Argument #1 ($separatorColor) must be a valid hexadecimal color code',
                    __METHOD__
                )
            );
        }

        $this->separatorColor = $separatorColor;

        return $this;
    }

    public function toArray()
    {
        $value = [];

        if (isset($this->backgroundColor)) {
            $value['backgroundColor'] = $this->backgroundColor;
        }

        if ($this->separator) {
            $value['separator'] = $this->separator;
            if (isset($this->separatorColor)) {
                $value['separatorColor'] = $this->separatorColor;
            }
        }

        return $value;
    }

}
