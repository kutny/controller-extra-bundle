<?php

namespace Kutny\ControllerExtraBundle;

use Kutny\ControllerExtraBundle\BeforeAction\BeforeActionResolver;
use Kutny\ControllerExtraBundle\ParamConverter\ParamConverterResolver;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;

class RequestAfterSecurityListener
{
    private $beforeActionResolver;
    private $paramConverterResolver;

    public function __construct(
        BeforeActionResolver $beforeActionResolver,
        ParamConverterResolver $paramConverterResolver
    ) {
        $this->beforeActionResolver = $beforeActionResolver;
        $this->paramConverterResolver = $paramConverterResolver;
    }

    public function onKernelRequest(GetResponseEvent $event)
    {
        $request = $event->getRequest();

        if (!$request->attributes->has('_annotation_list')) {
            return;
        }

        $annotationList = $request->attributes->get('_annotation_list');

        $response = $this->beforeActionResolver->createResponse($annotationList, $request);

        if ($response) {
            $event->setResponse($response);
            $event->stopPropagation();
            return;
        }

        $this->setResolvedActionArguments($annotationList, $request);
    }

    private function setResolvedActionArguments(AnnotationList $annotationList, Request $request)
    {
        $actionArguments = $this->paramConverterResolver->resolveArguments($annotationList, $request->attributes->get('_route_params'), $request);

        $this->setRequestParams($actionArguments, $request);
    }

    private function setRequestParams(array $actionArguments, Request $request)
    {
        $request->attributes->set('_route_params', $actionArguments);

        foreach ($actionArguments as $name => $value) {
            $request->attributes->set($name, $value);
        }
    }
}
