<?php

namespace NilsWisiol\FlightManagementBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('NilsWisiolFlightManagementBundle:Default:index.html.twig');
    }
}
