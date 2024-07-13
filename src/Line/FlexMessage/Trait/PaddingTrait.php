<?php

namespace ManhNt\Line\FlexMessage\Trait;

use ManhNt\Line\FlexMessage\Component\Padding;

/**
 * @experimental
 *
 * This class can be modified in any way, or even removed, at any time.
 * Precautions when using it in production environments.
 * They are purely to allow broad testing and feedback.
 *
 * @author Nguyen The Manh <nguyenthemanh26011996@gmail.com>
 */
trait PaddingTrait
{
    /**
     * Padding
     *
     * @var \ManhNt\Line\FlexMessage\Component\Offset
     */
    protected $padding;

    /**
     * Set offset
     *
     * @param  \ManhNt\Line\FlexMessage\Component\Offset  $offset
     * @return $this
     */
    public function padding(Padding $padding)
    {
        $this->padding = $padding;

        return $this;
    }
}
