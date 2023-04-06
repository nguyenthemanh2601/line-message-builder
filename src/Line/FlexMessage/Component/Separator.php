<?php

namespace ManhNt\Line\FlexMessage\Component;

use ManhNt\Contract\JsonAble;
use ManhNt\Contract\StringAble;
use ManhNt\Line\Contract\BoxContent;
use ManhNt\Line\FlexMessage\Component\ColorTrait;
use ManhNt\Line\FlexMessage\Component\MarginTrait;

class Separator implements BoxContent, JsonAble, StringAble
{
    use ColorTrait, MarginTrait;

    const TYPE = 'separator';

    public function toJson($options = 0)
    {
        return json_encode($this->toArray(), $options);
    }

    public function __toString()
    {
        try {
            return $this->toJson();
        } catch (\Exception $e) {
            return var_export($e);
        }
    }

    public function toArray()
    {
        $value =  array_merge(["type" => self::TYPE], get_object_vars($this));

        unset($value['allowedMarginValues']);

        return array_filter($value);
    }
}
