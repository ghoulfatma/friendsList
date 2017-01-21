<?php

namespace project\UserBundle\Controller;

use AppBundle\Entity\Bonobo;
use FOS\UserBundle\Controller\RegistrationController as BaseController;

class RegistrationController extends BaseController
{
    public function registerAction()
    {
        $form = $this->container->get('fos_user.registration.form');
        $formHandler = $this->container->get('fos_user.registration.form.handler');
        $confirmationEnabled = $this->container->getParameter('fos_user.registration.confirmation.enabled');

        $process = $formHandler->process($confirmationEnabled);
        if ($process) {
            $user = $form->getData();

            /*****************************************************
             * Add new functionality (e.g. log the registration) *
             *****************************************************/
            $friend = new Bonobo();
            $friend->setNom($user->getUsername());
            $friend->setUser($user);

            $em = $this->getDoctrine()->getManager();

            $em->persist($friend);
            $em->flush();
            $user->setBonobo($friend);
        }

        return $this->container->get('templating')->renderResponse('FOSUserBundle:Registration:register.html.twig', array(
            'form' => $form->createView(),
        ));
    }
}