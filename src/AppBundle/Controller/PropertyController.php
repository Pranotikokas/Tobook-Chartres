<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class PropertyController extends Controller
{
    public function indexAction()
    {
        return $this->render('AppBundle:property:index.html.twig');
    }
}
