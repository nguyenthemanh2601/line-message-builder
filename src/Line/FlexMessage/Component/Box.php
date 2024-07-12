<?php

namespace ManhNt\Line\FlexMessage\Component;

use ManhNt\Support\Str;
use UnexpectedValueException;
use ManhNt\Line\Contract\BoxContent;
use ManhNt\Line\Contract\BubbleHero;
use ManhNt\Exception\UnexpectedTypeException;
use ManhNt\Exception\ExpectedValueNotFoundException;
use ManhNt\Line\FlexMessage\Trait\FlexTrait;
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
class Box extends BoxContent implements BubbleHero
{
    use FlexTrait, MarginTrait;

    const TYPE = 'box';

    const ALLOWED_SPACINGS = ['sm', 'md', 'lg', 'xs', 'xl', 'xxl'];
    const ALLOWED_LAYOUT_TYPE = ['vertical', 'baseline', 'horizontal'];

    /**
     * Box layout
     *
     * @var string
     */
    protected $layout;

    /**
     * Box layout
     *
     * @var string
     */
    protected $spacing;

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

    public static function factory(array $contents = [])
    {
        return new static($contents);
    }

    /**
     * Add content
     * When the layout property is horizontal or vertical: box, button, image, text, separator, and filler
     * When the layout property is baseline: icon, text, and filler
     *
     * @param  \ManhNt\Line\Contract\BoxContent|array  $content
     * @return $this
     */
    public function addContent($content)
    {
        if (is_array($content)) {
            if (empty($content)) {
                throw new UnexpectedValueException(sprintf('%s: Argument #1 ($content) can not be empty', __METHOD__));
            }
            foreach ($content as $value) {
                if (!$value instanceof BoxContent) {
                    throw new UnexpectedTypeException($value, BoxContent::class);
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
     * @param  string  $layout
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

    /**
     * Set spacing
     *
     * @param  string  $spacing
     * @return $this
     */
    public function spacing($spacing)
    {
        if (!is_string($spacing)) {
            throw new UnexpectedTypeException($spacing, 'string');
        }

        if (Str::isEmpty($spacing)) {
            throw new UnexpectedValueException('Argument #1 ($text) can not be empty');
        }

        if (!in_array($spacing, static::ALLOWED_SPACINGS)) {
            throw new UnexpectedValueException(
                sprintf(
                    '%s Argument #1 ($layouts) must be one of the following values: %s',
                    __METHOD__,
                    implode(", ", static::ALLOWED_SPACINGS)
                )
            );
        }

        $this->spacing = $spacing;

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

        return array_filter($value, function ($v) {
            return !is_null($v);
        });
    }
}
