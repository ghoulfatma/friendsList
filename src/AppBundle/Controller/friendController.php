<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Bonobo;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;

class friendController extends Controller
{
    /**
     * @Route("/", name="friend_list")
     */
    public function listAction(Request $request)
    {
        $user1 = $this->get('security.token_storage')->getToken()->getUser();
        $user = $this->getDoctrine()
            ->getRepository('AppBundle:Bonobo')
            ->findOneByUser($user1);
        $friends = $user->getFriends();
        return $this->render('friendViews/index.html.twig', array(
            'friends' => $friends
        ));
    }
    /**
     * @Route("/friends/create", name="friend_create")
     */
    public function createAction(Request $request)
    {
        $friend = new Bonobo();
        $user1 = $this->get('security.token_storage')->getToken()->getUser();
        $user = $this->getDoctrine()
            ->getRepository('AppBundle:Bonobo')
            ->findOneByUser($user1);

        $form = $this->createFormBuilder($friend)
            ->add('nom',TextType::class, array('attr'=> array('class' => 'form-control', 'style' => 'margin-bottom:15px')))
            ->add('age',NumberType::class, array('attr'=> array('class' => 'form-control', 'style' => 'margin-bottom:15px')))
            ->add('famille',TextType::class, array('attr'=> array('class' => 'form-control', 'style' => 'margin-bottom:15px')))
            ->add('race',TextType::class, array('attr'=> array('class' => 'form-control', 'style' => 'margin-bottom:15px')))
            ->add('nourriture',TextareaType::class, array('attr'=> array('class' => 'form-control', 'style' => 'margin-bottom:15px')))
            ->add('Enregistrer',SubmitType::class, array('label' =>'Créer ami', 'attr'=> array('class' => 'btn btn-primary', 'style' => 'margin-bottom:15px')))
            ->getForm();


        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            // Get Data
            $nom = $form['nom']->getData();
            $age = $form['age']->getData();
            $famille = $form['famille']->getData();
            $race = $form['race']->getData();
            $nourriture = $form['nourriture']->getData();

            $friend->setNom($nom);
            $friend->setAge($age);
            $friend->setFamille($famille);
            $friend->setRace($race);
            $friend->setNourriture($nourriture);

            $user->addFriend($friend);

            $em = $this->getDoctrine()->getManager();

            $em->persist($friend);
            $em->flush();

            $this->addFlash(
                'notice',
                'Friend Ajouté'
            );

            return $this->redirectToRoute('friend_list');
        }
        return $this->render('friendViews/create.html.twig', array(
            'form' =>$form->createView()
        ));
    }
    /**
     * @Route("/friends/edit/{id}", name="friend_edit")
     */
    public function editAction($id,Request $request)
    {
        $friend = $this->getDoctrine()
            ->getRepository('AppBundle:Bonobo')
            ->find($id);

        $friend->setNom($friend->getNom());
        $friend->setAge($friend->getAge());
        $friend->setFamille($friend->getFamille());
        $friend->setRace($friend->getRace());
        $friend->setNourriture($friend->getNourriture());

        $form = $this->createFormBuilder($friend)
            ->add('nom',TextType::class, array('attr'=> array('class' => 'form-control', 'style' => 'margin-bottom:15px')))
            ->add('age',NumberType::class, array('attr'=> array('class' => 'form-control', 'style' => 'margin-bottom:15px')))
            ->add('famille',TextType::class, array('attr'=> array('class' => 'form-control', 'style' => 'margin-bottom:15px')))
            ->add('race',TextType::class, array('attr'=> array('class' => 'form-control', 'style' => 'margin-bottom:15px')))
            ->add('nourriture',TextareaType::class, array('attr'=> array('class' => 'form-control', 'style' => 'margin-bottom:15px')))
            ->add('Modifier',SubmitType::class, array('label' =>'Modifier ami', 'attr'=> array('class' => 'btn btn-primary', 'style' => 'margin-bottom:15px')))
            ->getForm();

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            // Get Data
            $nom = $form['nom']->getData();
            $age = $form['age']->getData();
            $famille = $form['famille']->getData();
            $race = $form['race']->getData();
            $nourriture = $form['nourriture']->getData();

            $em = $this->getDoctrine()->getManager();
            $friend = $em->getRepository('AppBundle:Bonobo')->find($id);

            $friend->setNom($nom);
            $friend->setAge($age);
            $friend->setFamille($famille);
            $friend->setRace($race);
            $friend->setNourriture($nourriture);


            $em->persist($friend);
            $em->flush();

            $this->addFlash(
                'notice',
                'Friend Modifier'
            );

            return $this->redirectToRoute('friend_list');
        }
        return $this->render('friendViews/create.html.twig', array(
            'form' =>$form->createView()
        ));
    }
    /**
     * @Route("/friends/details/{id}", name="friend_details")
     */
    public function detailsAction($id)
    {
        $friend = $this->getDoctrine()
            ->getRepository('AppBundle:Bonobo')
            ->find($id);

        return $this->render('friendViews/details.html.twig', array(
            'friend' => $friend
        ));
    }

    /**
     * @Route("/friends/delete/{id}", name="friend_delete")
     */
    public function deleteAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $friend = $em->getRepository('AppBundle:Bonobo')->find($id);

        $em->remove($friend);
        $em->flush();

        $this->addFlash(
            'notice',
            'Friend Supprimer'
        );

        return $this->redirectToRoute('friend_list');
    }
}