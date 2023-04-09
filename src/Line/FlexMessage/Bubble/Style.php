<?php

namespace ManhNt\Line\FlexMessage\Bubble;

use ManhNt\Support\Container;
use ManhNt\Contract\ArrayAble;
use ManhNt\Line\FlexMessage\Component\BlockStyle;

class Style implements ArrayAble
{
    public $header;
    public $hero;
    public $body;
    public $footer;

    public function __construct(BlockStyle $header = null, BlockStyle $hero = null, BlockStyle $body = null, BlockStyle $footer = null)
    {
        $this->header = $header;
        $this->hero = $hero;
        $this->body = $body;
        $this->footer = $footer;
        $this->initialize();
    }

    private function initialize()
    {
        foreach (get_object_vars($this) as $property => $value) {
            if (!$this->{$property}) {
                $this->{$property} = Container::getInstance()->make(BlockStyle::class);
            }
        }
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
