<?php

namespace ManhNt\Line\FlexMessage\Component;

use ManhNt\Support\Str;
use UnexpectedValueException;
use ManhNt\Contract\JsonAble;
use ManhNt\Contract\StringAble;
use ManhNt\Line\Contract\BoxContent;
use ManhNt\Line\FlexMessage\Component\FlexTrait;
use ManhNt\Line\FlexMessage\Component\MarginTrait;

class Image implements BoxContent, JsonAble, StringAble
{
    use FlexTrait, MarginTrait;

    const TYPE = 'image';
    const URL_MAX_LENGTH = 2000;
    const ALLOW_SIZES = ['sm', 'md', 'lg', 'xs', 'xl', 'xxs', 'xxl', '3xl', '4xl', '5xl', 'full'];

    /**
     * Image url
     *
     * @var string
     */
    protected $url;

    /**
     * Image size
     *
     * @var string
     */
    protected $size = 'md';

    public function url($url)
    {
        if (!filter_var($url, FILTER_VALIDATE_URL)) {
            throw new UnexpectedValueException('Argument #1 ($url) must be a valid url');
        }

        if (strlen($url) > self::URL_MAX_LENGTH) {
            throw new UnexpectedValueException(sprintf('Argument #1 ($url) cannot be longer than %d characters', self::URL_MAX_LENGTH));
        }

        $this->url = $url;

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
        if (!in_array($size, self::ALLOW_SIZES)) {
            $isNotValidPixelValue = !Str::endsWith($size, 'px')
            || !is_numeric(Str::before($size, 'px'))
            || Str::before($size, 'px') < "0";

            if ($isNotValidPixelValue) {
                throw new UnexpectedValueException('Argument #1 ($size) must be a positive integer or decimal number that ends in px. Examples include 50px and 23.5px');
            }
            $percentage  = Str::before($size, '%');
            $isNotValidPercentageValue = !Str::endsWith($size, '%')
            || !is_numeric($percentage)
            || ($percentage < 0  && $percentage > 100);

            if ($isNotValidPercentageValue) {
                throw new UnexpectedValueException('Argument #1 ($size) must be expressed as a positive integer or decimal number with %. Examples include 50% and 23.5%');
            }
        }

        $this->size = $size;

        return $this;
    }

    public function toArray()
    {
        if (!$this->url) {
            throw new UnexpectedValueException(sprintf('%s url is required.', __METHOD__));
        }

        $value =  array_merge(["type" => self::TYPE], get_object_vars($this));

        unset($value['allowedMarginValues']);

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
            return var_export($e);
        }
    }
}
