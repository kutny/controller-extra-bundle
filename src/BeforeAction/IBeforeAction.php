<?php

namespace Kutny\ControllerExtraBundle\BeforeAction;

use Symfony\Component\HttpFoundation\Request;

interface IBeforeAction
{
    public function createResponse(Request $request);
}
