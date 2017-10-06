<?php

namespace Kutny\ControllerExtraBundle;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;

class RequestBeforeSecurityListener
{
    private $container;
    private $controllerActionIdentificationParser;
    private $annotationListPreparer;

    public function __construct(
        ContainerInterface $container,
        ControllerActionIdentificationParser $controllerActionIdentificationParser,
        AnnotationListPreparer $annotationListPreparer
    ) {
        $this->container = $container;
        $this->controllerActionIdentificationParser = $controllerActionIdentificationParser;
        $this->annotationListPreparer = $annotationListPreparer;
    }

    public function onKernelRequest(GetResponseEvent $event)
    {
        $request = $event->getRequest();

        if (
            !$request->attributes->has('_controller')
            || (
                $this->container->hasParameter('twig.exception_listener.controller')
                && $request->attributes->get('_controller') === $this->container->getParameter('twig.exception_listener.controller')
            )
        ) {
            return;
        }

        $controllerServiceName = $this->controllerActionIdentificationParser->getControllerServiceName($request);
        $actionMethodName = $this->controllerActionIdentificationParser->getActionMethodName($request);
        $controllerService = $this->container->get($controllerServiceName);
        $controllerClassName = get_class($controllerService);

        $annotationList = $this->annotationListPreparer->prepareAnnotationList($controllerClassName, $actionMethodName);

        $request->attributes->set('_controller_service_name', $controllerServiceName);
        $request->attributes->set('_controller_class_name', $controllerClassName);
        $request->attributes->set('_controller_action_method_name', $actionMethodName);
        $request->attributes->set('_annotation_list', $annotationList);

        // for the Sensio\Bundle\FrameworkExtraBundle\EventListener\TemplateListener to work correctly
//        $request->attributes->set('_template', $annotationList->getAnnotation(Template::class));
        // TODO:
    }
}
