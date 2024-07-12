<?php

namespace ManhNt\Line\FlexMessage\Container;

use ManhNt\Line\Contract\BoxContent;

/**
 * @experimental
 *
 * This class can be modified in any way, or even removed, at any time.
 * Precautions when using it in production environments.
 * They are purely to allow broad testing and feedback.
 *
 * @author Nguyen The Manh <nguyenthemanh26011996@gmail.com>
 */

class Carousel extends BoxContent implements ContainerInterface
{
    const MAX_CONTENTS = 12;

    protected $type = 'carousel';

    /**
     * @var \ManhNt\Line\FlexMessage\Container\Bubble[]|\ManhNt\Line\FlexMessage\Container\Bubble
     */
    protected $contents = [];

    public function __construct($bubbles)
    {
        $this->addContents(is_array($bubbles) ? $bubbles : [$bubbles]);
    }

    public static function factory($bubbles)
    {
        return new static($bubbles);
    }

    /**
     * Add a content
     *
     * @param  \ManhNt\Line\FlexMessage\Container\Bubble $bubble
     * @return $this
     * @throws \LogicException
     */
    public function addContent(Bubble $bubble)
    {
        if (count($this->contents) > static::MAX_CONTENTS) {
            throw new \LogicException(
                sprintf(
                    "Maximum bubbles within a carousel is %d bubbles, cannot add more bubble",
                    static::MAX_CONTENTS
                )
            );
        }
        $this->contents[] = $bubble;

        return $this;
    }

    /**
     * Add a content
     *
     * @param  \ManhNt\Line\FlexMessage\Container\Bubble[] $bubble
     * @return $this
     */
    public function addContents(array $bubbles)
    {
        foreach ($bubbles as $bubble) {
            $this->addContent($bubble);
        }

        return $this;
    }

    /**
     * Flush all content
     *
     * @return $this
     */
    public function flushContent()
    {
        $this->contents = [];

        return $this;
    }

    public function toJson($options = 0)
    {
        return json_encode($this->toArray(), $options);
    }

    public function __toString()
    {
        return $this->toJson();
    }

    public function toArray()
    {
        $value = [
            "type" => $this->type,
            "contents" => [],
        ];

        foreach ($this->contents as $content) {
            $value["contents"][] = $content->toArray();
        }

        return $value;
    }
}
