<?php

namespace project\UserBundle\Form;

use AppBundle\Form\BonoboFormType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class RegistrationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);

        /*$builder->add('bonobo', CollectionType::class, array(
            'entry_type' => BonoboFormType::class
        ));*/
        $builder->add('x');
    }

    public function getParent()
    {
        return 'fos_user_registration';
    }

    public function getName()
    {
        return 'app_user_registration';
    }
}