<?php

namespace ManhNt\Line\FlexMessage\Component\Action;

use Exception;
use LogicException;
use ManhNt\Support\Str;
use UnexpectedValueException;
use ManhNt\Contract\JsonAble;
use ManhNt\Contract\StringAble;
use ManhNt\Exception\UnexpectedTypeException;
use ManhNt\Line\FlexMessage\Component\Action\ActionInterface;

class MessageAction implements ActionInterface, JsonAble, StringAble
{
    const TYPE = 'message';

    const TEXT_MAX_LENGTH = 300;

    const LABEL_MAX_LENGTH = 40;

    /**
     * Text sent when the action is performed. Max character limit: 300
     *
     * @var string
     */
    protected $text;

    /**
     * Label for the action.
     *
     * @var string
     */
    protected $label = null;

    /**
     * Set text.
     *
     * @param  string  $text  Max character limit: 40
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

        if (Str::length($text) > self::TEXT_MAX_LENGTH) {
            throw new UnexpectedValueException(sprintf('Length of argument #1 ($text) cannot exceed %d', self::TEXT_MAX_LENGTH));
        }

        $this->text = $text;

        return $this;
    }

    /**
     * Set label.
     *
     * @param  string  $label  Max character limit
     * @return $this
     */
    public function label($label)
    {
        if (!is_string($label)) {
            throw new UnexpectedTypeException($label, 'string');
        }

        if (Str::isEmpty($label)) {
            throw new UnexpectedValueException('Argument #1 ($label) can not be empty');
        }

        if (Str::length($label) > self::LABEL_MAX_LENGTH) {
            throw new UnexpectedValueException(sprintf('Length of argument #1 ($label) cannot exceed %d', self::LABEL_MAX_LENGTH));
        }

        $this->label = $label;

        return $this;
    }

    public function toJson($options = 0)
    {
        return json_encode($this->toArray());
    }

    public function __toString()
    {
        try {
            return $this->toJson();
        } catch (Exception $e) {
            return var_export($e);
        }
    }

    public function toArray()
    {
        if (Str::isEmpty($this->text)) {
            throw new LogicException('Please set action text first.');
        }

        return array_merge(["type" => self::TYPE], array_filter(get_object_vars($this)));
    }
}
