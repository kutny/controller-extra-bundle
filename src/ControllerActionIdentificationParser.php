<?php

namespace Kutny\ControllerExtraBundle;

use Symfony\Component\HttpFoundation\Request;

class ControllerActionIdentificationParser
{
    public function getControllerServiceName(Request $request)
    {
        $controllerActionIdentifier = $request->attributes->get('_controller');

        return substr($controllerActionIdentifier, 0, strpos($controllerActionIdentifier, ':'));
    }

    public function getActionMethodName(Request $request)
    {
        $controllerActionIdentifier = $request->attributes->get('_controller');

        return substr($controllerActionIdentifier, strpos($controllerActionIdentifier, ':') + 2);
    }
}
