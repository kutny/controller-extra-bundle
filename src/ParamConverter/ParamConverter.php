<?php

namespace Kutny\ControllerExtraBundle\ParamConverter;

/** @Annotation */
class ParamConverter
{
    private $service;

    public function __construct(array $values)
    {
        $this->service = $values['service'];
    }

    public function getService()
    {
        return $this->service;
    }
}
