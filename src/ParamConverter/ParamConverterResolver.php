<?php

namespace Kutny\ControllerExtraBundle\ParamConverter;

use Kutny\ControllerExtraBundle\AnnotationList;
use Psr\Container\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;

class ParamConverterResolver
{
    private $container;

    public function __construct(
        ContainerInterface $container
    ) {
        $this->container = $container;
    }

    public function resolveArguments(AnnotationList $annotationList, array $routeArguments, Request $request)
    {
        if ($annotationList->hasAnnotation(ParamConverter::class)) {
            /** @var ParamConverter[] $annotations */
            $annotations = $annotationList->getAnnotations(ParamConverter::class);

            foreach ($annotations as $annotation) {
                /** @var IParamConverter $paramConverter */
                $paramConverter = $this->container->get($annotation->getService());

                $routeArguments = $paramConverter->convert($routeArguments, $request);
            }
        }

        return $routeArguments;
    }
}
