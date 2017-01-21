<?php

namespace project\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Session\Session;

class DefaultController extends Controller
{
    public function indexAction()
    {
        $friends = $this->getDoctrine()
            ->getRepository('AppBundle:Bonobo')
            ->findAll();
        return $this->render('friendViews/index.html.twig', array(
            'friends' => $friends
        ));
    }
}
