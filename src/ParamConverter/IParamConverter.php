<?php

namespace Kutny\ControllerExtraBundle\ParamConverter;

use Symfony\Component\HttpFoundation\Request;

interface IParamConverter
{
    /**
     * @param array $allRouteArguments
     * @param Request $request
     * @return array
     */
    public function convert(array $allRouteArguments, Request $request);
}
