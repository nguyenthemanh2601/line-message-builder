<?php

namespace ManhNt\Line\FlexMessage\Component;

use ManhNt\Line\Contract\BoxContent;
use ManhNt\Line\FlexMessage\Component\BlockStyle;

/**
 * @experimental
 *
 * This class can be modified in any way, or even removed, at any time.
 * Precautions when using it in production environments.
 * They are purely to allow broad testing and feedback.
 *
 * @author Nguyen The Manh <nguyenthemanh26011996@gmail.com>
 */
class Style extends BoxContent
{
    public $header;
    public $hero;
    public $body;
    public $footer;

    public function __construct(
        BlockStyle $header = null,
        BlockStyle $hero = null,
        BlockStyle $body = null,
        BlockStyle $footer = null
    ) {
        $this->header = $header;
        $this->hero = $hero;
        $this->body = $body;
        $this->footer = $footer;
        $this->initialize();
    }

    /**
     * @return $this
     */
    public static function factory(
        BlockStyle $header = null,
        BlockStyle $hero = null,
        BlockStyle $body = null,
        BlockStyle $footer = null
    ) {
        return new static($header, $hero, $body, $footer);
    }

    public function header(BlockStyle $header)
    {
        $this->header = $header;

        return $this;
    }

    public function hero(BlockStyle $hero)
    {
        $this->hero = $hero;

        return $this;
    }

    public function body(BlockStyle $body)
    {
        $this->body = $body;

        return $this;
    }

    public function footer(BlockStyle $footer)
    {
        $this->footer = $footer;

        return $this;
    }

    private function initialize()
    {
        foreach (get_object_vars($this) as $property => $value) {
            if (!$this->{$property}) {
                $this->{$property} = new BlockStyle;
            }
        }
    }

    public function __toString()
    {
        return $this->toJson();
    }

    public function toJson($options = 0)
    {
        return json_encode($this->toArray(), $options);
    }

    public function toArray()
    {
        $value = [];
        foreach (get_object_vars($this) as $k => $v) {
            $data = $v->toArray();
            if (!empty($data)) {
                $value[$k] = $data;
            }
        }

        return $value;
    }
}
