<?php

namespace ManhNt\Line\FlexMessage\Component;

use UnexpectedValueException;
use ManhNt\Contract\ArrayAble;
use ManhNt\Line\Contract\BoxContent;
use ManhNt\Line\Contract\BubbleHero;
use ManhNt\Line\FlexMessage\Trait\FlexTrait;
use ManhNt\Line\FlexMessage\Trait\ActionTrait;
use ManhNt\Line\FlexMessage\Trait\ColorTrait;
use ManhNt\Line\FlexMessage\Trait\MarginTrait;
use ManhNt\Line\FlexMessage\Component\Action\ActionInterface;

class Button extends BoxContent implements BubbleHero
{
    use FlexTrait, MarginTrait, ColorTrait, ActionTrait;
    const ALLOWED_HEIGHT = ['sm', 'md'];
    const ALLOWED_STYLE = ['primary', 'secondary', 'link'];

    /** @var string */
    protected $type = 'button';

    /**
     * Height of the button
     *
     * @var string
     */
    protected $height;

    /**
     * Height of the button
     *
     * @var string
     */
    protected $style;

    public function __construct(ActionInterface $action = null)
    {
        if (!is_null($action)) {
            $this->action($action);
        }
    }

    public static function factory(ActionInterface $action = null)
    {
        return new static($action);
    }

    /**
     * Set height for button
     *
     * @param  string  $value sm|md
     * @throws \UnexpectedValueException
     * @return $this
     */
    public function height($value)
    {
        if (!in_array($value, static::ALLOWED_HEIGHT)) {
            throw new UnexpectedValueException(
                sprintf(
                    'Argument #1 ($value) must be one of the following values: %s',
                    implode(", ", static::ALLOWED_HEIGHT)
                )
            );
        }
        $this->height = $value;

        return $this;
    }

    /**
     * Set height for button
     *
     * @param  string  $value primary|secondary|link
     * @throws \UnexpectedValueException
     * @return $this
     */
    public function style($value)
    {
        if (!in_array($value, static::ALLOWED_STYLE)) {
            throw new UnexpectedValueException(
                sprintf(
                    'Argument #1 ($value) must be one of the following values: %s',
                    implode(", ", static::ALLOWED_STYLE)
                )
            );
        }
        $this->style = $value;

        return $this;
    }

    public function toArray()
    {
        if (!$this->action) {
            throw new UnexpectedValueException(sprintf('%s action is required.', __CLASS__));
        }
        $value = array_filter(get_object_vars($this));

        foreach ($value as $k => $v) {
            if ($v instanceof ArrayAble) {
                $value[$k] = $v->toArray();
            }
        }

        return array_filter($value);
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
}
