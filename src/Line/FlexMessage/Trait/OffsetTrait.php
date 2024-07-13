<?php

namespace ManhNt\Line\FlexMessage\Trait;

use ManhNt\Line\FlexMessage\Component\Offset;

/**
 * @experimental
 *
 * This class can be modified in any way, or even removed, at any time.
 * Precautions when using it in production environments.
 * They are purely to allow broad testing and feedback.
 *
 * @author Nguyen The Manh <manh.nguyen3@ntq-solution.com.vn>
 */
trait OffsetTrait
{

    /**
     * Offset
     *
     * @var \ManhNt\Line\FlexMessage\Component\Offset
     */
    protected $offset;

    /**
     * Set offset
     *
     * @param  \ManhNt\Line\FlexMessage\Component\Offset  $offset
     * @return $this
     */
    public function offset(Offset $offset)
    {
        $this->offset = $offset;

        return $this;
    }
}
