<?php

namespace ManhNt\Line\FlexMessage\Component;

use TypeError;
use ManhNt\Support\Str;
use UnexpectedValueException;
use ManhNt\Line\Contract\BoxContent;
use ManhNt\Exception\UnexpectedTypeException;
use ManhNt\Line\FlexMessage\Component\MarginTrait;
use ManhNt\Exception\ExpectedValueNotFoundException;

class Box extends BoxContent
{
    use MarginTrait;

    const TYPE = 'box';

    const ALLOWED_LAYOUT_TYPE = ['vertical', 'baseline', 'horizontal'];

    /**
     * Box layout
     *
     * @var string
     */
    protected $layout;

    /**
     * Box contents
     *
     * @var array
     */
    protected $contents;

    public function __construct(array $contents = [])
    {
        $this->contents = $contents;
    }

    /**
     * Add content
     * When the layout property is horizontal or vertical: box, button, image, text, separator, and filler
     * When the layout property is baseline: icon, text, and filler
     *
     * @param  \ManhNt\Line\Contract\BoxContent|array  $content
     * @return array
     */
    public function addContent($content)
    {
        if (is_array($content)) {
            if (empty($content)) {
                throw new UnexpectedValueException(sprintf('%s: Argument #1 ($content) can not be empty', __METHOD__));
            }
            foreach ($content as $key => $value) {
                if (!$value instanceof BoxContent) {
                    throw new TypeError(
                        sprintf(
                            '%s: Argument #1 ($content[%d]) must be of type %s, %s given',
                            __METHOD__,
                            $key,
                            BoxContent::class,
                            gettype($value)
                        )
                    );
                }
                $this->contents[] = $value;
            }
        } elseif (!$content instanceof BoxContent) {
            throw new UnexpectedValueException(
                sprintf(
                    '%s: Argument #1 ($content)  must be instance of, %s given',
                    __METHOD__,
                    BoxContent::class,
                    gettype($content)
                )
            );
        } else {
            $this->contents[] = $content;
        }

        return $this;
    }

    /**
     * Set layout
     *
     * @param  string  $action
     * @return $this
     */
    public function layout($layout)
    {
        if (!is_string($layout)) {
            throw new UnexpectedTypeException($layout, 'string');
        }

        if (Str::isEmpty($layout)) {
            throw new UnexpectedValueException('Argument #1 ($text) can not be empty');
        }

        if (!in_array($layout, static::ALLOWED_LAYOUT_TYPE)) {
            throw new UnexpectedValueException(
                sprintf(
                    '%s Argument #1 ($layouts) must be one of the following values: %s',
                    __METHOD__,
                    implode(", ", static::ALLOWED_LAYOUT_TYPE)
                )
            );
        }

        $this->layout = $layout;

        return $this;
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
            return print_r([
                'message' => $e->getMessage(),
                'code' => $e->getCode(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString(),
            ], true);
        }
    }

    private function checkRequiredProperties()
    {
        $requiredProperties = ['contents', 'layout'];

        foreach ($requiredProperties as $requiredProperty) {
            if (empty($this->{$requiredProperty})) {
                throw new ExpectedValueNotFoundException(
                    sprintf("%s::{$requiredProperty} can not be empty", __CLASS__)
                );
            }
        }
    }

    protected function convertArrayAbleProperties()
    {
        $convertedProperties = [];
        $arrayAbleProperties = ['contents'];
        foreach ($arrayAbleProperties as $arrayAbleProperty) {
            if (is_array($this->{$arrayAbleProperty})) {
                foreach ($this->{$arrayAbleProperty} as $key => $value) {
                    $convertedProperties[$arrayAbleProperty][$key] = $this->{$arrayAbleProperty}[$key]->toArray();
                }
            } elseif (!empty($this->{$arrayAbleProperty})) {
                $convertedProperties[$arrayAbleProperty] = $this->{$arrayAbleProperty}->toArray();
            }
        }

        return $convertedProperties;
    }

    public function toArray()
    {
        $this->checkRequiredProperties();
        $value =  array_merge(["type" => self::TYPE], get_object_vars($this), $this->convertArrayAbleProperties());

        unset($value['allowedMarginValues']);

        return array_filter($value);
    }
}
