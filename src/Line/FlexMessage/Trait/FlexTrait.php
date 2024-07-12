<?php

namespace ManhNt\Line\FlexMessage\Trait;

use UnexpectedValueException;

/**
 * @experimental
 *
 * This class can be modified in any way, or even removed, at any time.
 * Precautions when using it in production environments.
 * They are purely to allow broad testing and feedback.
 *
 * @author Nguyen The Manh <nguyenthemanh26011996@gmail.com>
 */
trait FlexTrait
{
    /**
     * The ratio of the width or height of this component within the parent box.
     *
     * @var int
     * @see https://developers.line.biz/en/docs/messaging-api/flex-message-layout/#horizontal-box
     */
    protected $flex = 1;

    /**
     * Set ratio of the width or height of this component within the parent box.
     *
     * @param  int  $ratio
     * @return $this
     */
    public function flex($ratio)
    {
        if (0 > $ratio) {
            throw new UnexpectedValueException(sprintf('%s: Argument #1 ($ratio) must be greater than or equal to 0', __METHOD__));
        }

        $this->flex = $ratio;

        return $this;
    }
}
