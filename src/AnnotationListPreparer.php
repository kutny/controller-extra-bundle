<?php

namespace Kutny\ControllerExtraBundle;

use Doctrine\Common\Annotations\Reader;

class AnnotationListPreparer
{
    private $annotationsReader;

    public function __construct(
        Reader $annotationsReader
    ) {
        $this->annotationsReader = $annotationsReader;
    }

    public function prepareAnnotationList($controllerClassName, $actionMethodName)
    {
        $object = new \ReflectionClass($controllerClassName);
        $method = $object->getMethod($actionMethodName);

        return new AnnotationList($this->annotationsReader->getMethodAnnotations($method));
    }
}
