<?php

namespace ManhNt\Line\FlexMessage\Component\Action;

use Exception;
use ManhNt\Support\Str;
use UnexpectedValueException;
use ManhNt\Contract\JsonAble;
use ManhNt\Contract\StringAble;
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
class UriAction implements ActionInterface, JsonAble, StringAble
{
    protected $type = 'uri';

    const LABEL_MAX_LENGTH = 40;

    /**
     * Label for the action.
     *
     * @var string
     */
    protected $label = null;

    /**
     * Uri for the action.
     *
     * @var string
     */
    protected $uri = null;

    public function __construct($uri = null, $label = null)
    {
        if ($uri) {
            $this->uri($uri);
        }
        if ($label) {
            $this->label($label);
        }
    }

    public static function factory($uri = null, $label = null)
    {
        return new static($uri, $label);
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

    /**
     * Set uri.
     *
     * @param  string  $uri
     * @return $this
     */
    public function uri($uri)
    {
        if (!is_string($uri)) {
            throw new UnexpectedTypeException($uri, 'string');
        }

        if (Str::isEmpty($uri)) {
            throw new UnexpectedValueException('Argument #1 ($label) can not be empty');
        }

        $this->uri = $uri;

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
            return var_export($e, true);
        }
    }

    public function toArray()
    {
        return array_filter(get_object_vars($this));
    }
}
