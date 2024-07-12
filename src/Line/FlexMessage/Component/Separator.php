<?php

namespace ManhNt\Line\FlexMessage\Component;

use ManhNt\Line\Contract\BoxContent;
use ManhNt\Line\FlexMessage\Trait\ColorTrait;
use ManhNt\Line\FlexMessage\Trait\MarginTrait;

/**
 * @experimental
 *
 * This class can be modified in any way, or even removed, at any time.
 * Precautions when using it in production environments.
 * They are purely to allow broad testing and feedback.
 *
 * @author Nguyen The Manh <nguyenthemanh26011996@gmail.com>
 */

class Separator extends BoxContent
{
    use ColorTrait, MarginTrait;

    protected $type = 'separator';

    /**
     * @return $this
     */
    public static function factory()
    {
        return new static;
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

    public function toArray()
    {
        return array_filter(get_object_vars($this));
    }
}
