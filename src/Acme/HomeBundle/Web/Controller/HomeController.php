<?php

namespace Acme\HomeBundle\Web\Controller;

use Acme\CommonBundle\Web\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class HomeController extends Controller
{
    public function homeAction(Request $request)
    {
        return $this->render('AcmeHomeBundle:Home:home.html.twig');
    }
}