<?php

namespace ManhNt\Line\FlexMessage\Component;

use ManhNt\Support\Str;
use UnexpectedValueException;
use ManhNt\Line\Contract\BoxContent;
use ManhNt\Line\FlexMessage\Trait\MarginTrait;

class Icon extends BoxContent
{
    use MarginTrait;

    const TYPE = 'icon';
    const URL_MAX_LENGTH = 2000;
    const ALLOW_SIZES = ['sm', 'md', 'lg', 'xs', 'xl', 'xxs', 'xxl', '3xl', '4xl', '5xl'];

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

    /**
     * Aspect ratio of the image
     *
     * @var string
     */
    protected $aspectRatio = "1:1";

    public function __construct($url = null, $size = null)
    {
        if ($url) {
            $this->url($url);
        }
        $this->size($size);
    }

    public static function factory($url = null, $size = null)
    {
        return new static($url, $size);
    }

    /**
     * Set image url
     *
     * @param  string  $url http://www.faqs.org/rfcs/rfc2396.html
     * @throws \UnexpectedValueException
     * @return $this
     */
    public function url($url)
    {
        if (!filter_var($url, FILTER_VALIDATE_URL)) {
            throw new UnexpectedValueException('Argument #1 ($url) must be a valid url');
        }

        if (Str::length($url) > static::URL_MAX_LENGTH) {
            throw new UnexpectedValueException(sprintf('Argument #1 ($url) cannot be longer than %d characters', static::URL_MAX_LENGTH));
        }

        $this->url = $url;

        return $this;
    }

    /**
     * Set image url
     *
     * @param  string  $ratio {width}:{height}
     * @throws \UnexpectedValueException
     * @return $this
     */
    public function aspectRatio($ratio)
    {
        if (!preg_match("/^(100000|[1-9][0-9]{0,4}):(100000|[1-9][0-9]{0,4})$/", $ratio, $matches)) {
            throw new UnexpectedValueException('Argument #1 ($ratio) must be has {width}:{height} format. Specify the value of {width} and {height} in the range from 1 to 100000');
        }
        list(, $width, $height) = $matches;

        if ($width * 3 < $height) {
            throw new UnexpectedValueException('Cannot set {height} to a value that is more than three times the value of {width}');
        }

        $this->aspectRatio = $ratio;

        return $this;
    }

    /**
     * Set font size
     *
     * @param  string  $size
     * @throws \UnexpectedValueException
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
            $percentage = Str::before($size, '%');
            $isNotValidPercentageValue = !Str::endsWith($size, '%')
                || !is_numeric($percentage)
                || ($percentage < 0 && $percentage > 100);

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

        $value = array_merge(["type" => self::TYPE], get_object_vars($this));

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
