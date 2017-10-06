<?php

namespace Kutny\ControllerExtraBundle\BeforeAction;

/**
 * @Annotation
 */
class BeforeAction
{
    private $service;

    public function __construct($options)
    {
        $this->service = $options['service'];
    }

    public function getService()
    {
        return $this->service;
    }
}
