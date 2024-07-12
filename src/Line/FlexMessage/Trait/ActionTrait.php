<?php

namespace ManhNt\Line\FlexMessage\Trait;

use ManhNt\Line\FlexMessage\Component\Action\ActionInterface;

/**
 * @experimental
 *
 * This class can be modified in any way, or even removed, at any time.
 * Precautions when using it in production environments.
 * They are purely to allow broad testing and feedback.
 *
 * @author Nguyen The Manh <nguyenthemanh26011996@gmail.com>
 */
trait ActionTrait
{
    /**
     * Action instance
     *
     * @var \ManhNt\Line\FlexMessage\Component\Action\ActionInterface
     */
    protected $action;

    /**
     * Set action
     *
     * @param  \ManhNt\Line\FlexMessage\Component\Action\ActionInterface  $action
     * @return $this
     */
    public function action(ActionInterface $action)
    {
        $this->action = $action;

        return $this;
    }
}
