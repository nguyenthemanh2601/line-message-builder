<?php

namespace ManhNt\Line\FlexMessage\Component;

use Exception;
use ManhNt\Support\Str;
use UnexpectedValueException;
use ManhNt\Line\Contract\BoxContent;
use ManhNt\Exception\UnexpectedTypeException;
use ManhNt\Line\FlexMessage\Component\FlexTrait;
use ManhNt\Line\FlexMessage\Component\ColorTrait;
use ManhNt\Line\FlexMessage\Component\Action\ActionInterface;

class Text extends BoxContent
{
    use FlexTrait, ColorTrait;

    const TYPE = 'text';

    const ALLOWED_FONT_SIZE = ['sm', 'md', 'lg', 'xs', 'xl', 'xxs', 'xxl', '3xl', '4xl', '5xl'];

    const ALLOWED_FONT_WEIGHT = ['bold', 'regular'];

    const ALLOWED_FONT_STYLE = ['normal', 'italic'];

    const ALLOWED_DECORATION = ['none', 'underline', 'line-through'];

    /**
     * Text
     *
     * @var string
     */
    protected $text;

    /**
     * Wrap text.
     *
     * @var bool
     */
    protected $wrap = false;

    /**
     * Font size
     *
     * @var string
     */
    protected $size;

    /**
     * Style of the text.
     *
     * @var string
     */
    protected $decoration;

    /**
     * Style of the text.
     *
     * @var string
     */
    protected $style;

    /**
     * Font weight
     *
     * @var string
     */
    protected $weight;

    /**
     * Action
     *
     * @var \ManhNt\Line\FlexMessage\Component\Action\ActionInterface
     */
    protected $action;

    /**
     * Set text. Be sure to set either one of the text property or contents
     * property. If you set the contents property, text is ignored.
     *
     * @param  string  $text
     * @return $this
     */
    public function text($text)
    {
        if (!is_string($text)) {
            throw new UnexpectedTypeException($text, 'string');
        }

        if (Str::isEmpty($text)) {
            throw new UnexpectedValueException('Argument #1 ($text) can not be empty');
        }

        $this->text = $text;

        return $this;
    }

    /**
     * Set font size
     *
     * @param  string  $text
     * @return $this
     */
    public function size($size)
    {
        if (!is_string($size)) {
            throw new UnexpectedTypeException($size, 'string');
        }

        $isNotValidSize = !in_array($size, static::ALLOWED_FONT_SIZE)
            && (!Str::endsWith($size, 'px')
                || !is_numeric(Str::before($size, 'px'))
                || Str::before($size, 'px') < "0");

        if ($isNotValidSize) {
            throw new UnexpectedValueException('Argument #1 ($size) must be a positive integer or decimal number that ends in px. Examples include 50px and 23.5px');
        }

        $this->size = $size;

        return $this;
    }

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

        if (!in_array($weight, static::ALLOWED_FONT_WEIGHT)) {
            throw new UnexpectedValueException(
                sprintf(
                    'Argument #1 ($weight) must be one of the following values: %s',
                    implode(", ", static::ALLOWED_FONT_WEIGHT)
                )
            );
        }

        $this->weight = $weight;

        return $this;
    }

    /**
     * Set style of the text.
     *
     * @param  string  $style
     * @return $this
     */
    public function style($style)
    {
        if (!is_string($style)) {
            throw new UnexpectedTypeException($style, 'string');
        }

        if (is_string($style) && !in_array($style, static::ALLOWED_FONT_STYLE)) {
            throw new UnexpectedValueException(
                sprintf(
                    'Argument #1 ($style) must be one of the following values: %s',
                    implode(", ", static::ALLOWED_FONT_STYLE)
                )
            );
        }

        $this->style = $style;

        return $this;
    }

    /**
     * Set decoration of the text.
     *
     * @param  string  $decoration
     * @return $this
     */
    public function decoration($decoration)
    {
        if (is_string($decoration) && !in_array($decoration, static::ALLOWED_DECORATION)) {
            throw new UnexpectedValueException(
                sprintf(
                    'Argument #1 ($decoration) must be one of the following values: %s',
                    implode(", ", static::ALLOWED_DECORATION)
                )
            );
        }

        $this->decoration = $decoration;

        return $this;
    }

    /**
     * Set action
     *
     * @param  \ManhNt\Line\FlexMessage\Component\Action\ActionInterface  $action
     * @return $this
     */
    public function action(ActionInterface $action)
    {
        $this->action = $action;

        return $this;
    }

    /**
     * Wrap text. If set to true, you can use a new line character (\n) to begin on a new line.
     *
     * @param  bool  $wrap
     * @return $this
     */
    public function wrap($wrap)
    {
        if (!is_bool($wrap)) {
            throw new UnexpectedTypeException($wrap, 'bool');
        }

        $this->wrap = $wrap;

        return $this;
    }

    public function toArray()
    {
        $values = [
            'type' => self::TYPE,
            "wrap"  => $this->wrap
        ];
        if (isset($this->flex)) {
            $values['flex'] = $this->flex;
        }
        if (!empty($this->action)) {
            $values['action'] = $this->action->toArray();
        }

        $values = array_merge(get_object_vars($this), $values);

        return array_filter($values);
    }

    public function toJson($options = 0)
    {
        return json_encode($this->toArray(), $options);
    }

    public function __toString()
    {
        try {
            return $this->toJson();
        } catch (Exception $e) {
            return var_export($e);
        }
    }
}
