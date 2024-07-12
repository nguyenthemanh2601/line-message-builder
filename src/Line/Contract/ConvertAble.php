<?php

namespace ManhNt\Line\Contract;

use JsonSerializable;
use ManhNt\Contract\JsonAble;
use ManhNt\Contract\ArrayAble;
use ManhNt\Contract\StringAble;


abstract class ConvertAble implements JsonAble, ArrayAble, StringAble, JsonSerializable
{
    public function jsonSerialize()
    {
        return $this->toArray();
    }
}
