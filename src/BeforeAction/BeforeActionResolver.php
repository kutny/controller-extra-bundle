<?php

namespace Kutny\ControllerExtraBundle\BeforeAction;

use Kutny\ControllerExtraBundle\AnnotationList;
use Psr\Container\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;

class BeforeActionResolver
{
    private $container;

    public function __construct(
        ContainerInterface $container
    ) {
        $this->container = $container;
    }

    public function createResponse(AnnotationList $annotationList, Request $request)
    {
        /** @var BeforeAction $annotation */
        $annotation = $annotationList->getAnnotation(BeforeAction::class);

        if (!$annotation) {
            return null;
        }

        /** @var IBeforeAction $beforeAction */
        $beforeAction = $this->container->get($annotation->getService());

        return $beforeAction->createResponse($request);
    }
}
