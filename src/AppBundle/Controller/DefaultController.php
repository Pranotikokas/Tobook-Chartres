<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('AppBundle:default:index.html.twig', array(
            'base_dir' => realpath($this->container->getParameter('kernel.root_dir').'/..'),
        ));
    }

    /**
     * @Route("/recherche", name="recherche")
     */
    public function rechercheAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('AppBundle:recherche:index.html.twig', array(
            'base_dir' => realpath($this->container->getParameter('kernel.root_dir').'/..'),
        ));
    }  

    public function changeLocaleAction(Request $request)
    {
        $request = $this->getRequest();
        echo $request->getLocale();

        $lg = $request->get('langue');
        echo $lg;

       $request = $this->getRequest();
       $request->setLocale($lg);

        $request = $this->getRequest();
        echo $request->getLocale();

        return $this->redirect($this->generateUrl('home', array('_locale' => $lg)));
    }  
}
