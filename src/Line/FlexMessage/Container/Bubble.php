<?php

namespace ManhNt\Line\FlexMessage\Container;

use UnexpectedValueException;
use ManhNt\Contract\ArrayAble;
use ManhNt\Exception\UnexpectedTypeException;
use ManhNt\Line\Contract\BubbleHero;
use ManhNt\Line\Contract\BoxContent;
use ManhNt\Line\FlexMessage\Component\Box;
use ManhNt\Line\FlexMessage\Component\Style;

/**
 * @experimental
 *
 * This class can be modified in any way, or even removed, at any time.
 * Precautions when using it in production environments.
 * They are purely to allow broad testing and feedback.
 *
 * @author Nguyen The Manh <nguyenthemanh26011996@gmail.com>
 */
class Bubble extends BoxContent implements ContainerInterface
{
    const ALLOWED_SIZE = ['nano', 'micro', 'deca', 'hecto', 'kilo', 'mega', 'giga'];
    const ALLOWED_DIRECTION = [
        'ltr', // The text is left-to-right horizontal writing, and the components are placed from left to right
        'rtl', // The text is right-to-left horizontal writing, and the components are placed from right to left
    ];

    /**
     * @var string
     */
    protected $type = 'bubble';

    /** @var \ManhNt\Line\FlexMessage\Component\Box */
    public $body;

    /** @var \ManhNt\Line\FlexMessage\Component\Style */
    public $styles;

    /**
     * The size of the bubble.
     *
     * @var string
     */
    protected $size;

    /**
     * Text directionality and the direction of placement of components in horizontal boxes.
     *
     * @var string
     */
    protected $direction;

    /**
     * Header block
     *
     * @var \ManhNt\Line\FlexMessage\Component\Box
     */
    protected $header;

    /**
     * Hero block
     * @var \ManhNt\Line\Contract\BubbleHero
     */
    protected $hero;

    /**
     * Footer block
     *
     * @var \ManhNt\Line\FlexMessage\Component\Box
     */
    protected $footer;

    public function __construct(Box $body = null, Style $style = null)
    {
        $this->body($body ?: new Box);
        $this->style($style ?: new Style);
    }

    public static function factory(Box $body = null, Style $style = null)
    {
        return new static($body, $style);
    }

    public function body(Box $body)
    {
        $this->body = $body;

        return $this;
    }

    public function style(Style $style)
    {
        $this->styles = $style;

        return $this;
    }

    /**
     * Add hero block
     *
     * @param \ManhNt\Line\Contract\BubbleHero|null $hero
     * @return $this
     */
    public function hero(BubbleHero $hero = null)
    {
        $this->hero = $hero;

        return $this;
    }

    /**
     * Add header block
     * 
     * @param \ManhNt\Line\FlexMessage\Component\Box|null $header
     * @return $this
     */
    public function header(Box $header = null)
    {
        if (func_num_args()) {
            $this->header = $header;
        }

        return $this;
    }

    /**
     * Add footer block
     *
     * @param \ManhNt\Line\FlexMessage\Component\Box|null $footer
     * @return $this
     */
    public function footer(Box $footer = null)
    {
        if (func_num_args()) {
            $this->footer = $footer;
        }

        return $this;
    }

    /**
     * Set the size for the bubble
     *
     * @param  string  $size
     * @return $this
     * @throws \UnexpectedValueException|\ManhNt\Exception\UnexpectedTypeException
     */
    public function size($size)
    {
        if (!is_string($size)) {
            throw new UnexpectedTypeException($size, 'string');
        }

        if (!in_array($size, static::ALLOWED_SIZE)) {
            throw new UnexpectedValueException(
                sprintf(
                    'Argument #1 ($size) is invalid. You can specify one of the following values: %s',
                    implode(", ", static::ALLOWED_SIZE)
                )
            );
        }

        $this->size = $size;

        return $this;
    }

    /**
     * Set the direction for the bubble
     *
     * @param  string  $direction
     * @return $this
     * @throws \UnexpectedValueException|\ManhNt\Exception\UnexpectedTypeException
     */
    public function direction($direction)
    {
        if (!is_string($direction)) {
            throw new UnexpectedTypeException($direction, 'string');
        }

        if (!in_array($direction, static::ALLOWED_DIRECTION)) {
            throw new UnexpectedValueException(
                sprintf(
                    'Argument #1 ($direction) is invalid. You can specify one of the following values: %s',
                    implode(", ", static::ALLOWED_DIRECTION)
                )
            );
        }

        $this->direction = $direction;

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
            trigger_error(print_r([
                'message' => $e->getMessage(),
                'trace'   => $e->getTraceAsString(),
            ], true), E_USER_NOTICE);
            return '';
        }
    }

    public function toArray()
    {
        $value = get_object_vars($this);

        foreach ($value as $k => $v) {
            if ($v instanceof ArrayAble) {
                $value[$k] = $v->toArray();
            }
        }

        return array_filter($value);
    }
}
