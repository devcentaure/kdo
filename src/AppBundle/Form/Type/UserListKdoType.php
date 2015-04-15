<?php

namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

class UserListKdoType extends AbstractType
{

    private $userListKdoManager;

    private $security;

    public function  __construct($userListKdoManager, SecurityContext $securityContext)
    {
        $this->userListKdoManager = $userListKdoManager;

        $this->security = $securityContext;
    }


    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $security = $this->security;

        $builder
            ->add('listKdo')
            ->add('user');

        $builder->addEventListener(
            FormEvents::PRE_SET_DATA,
            function (FormEvent $event) use ($security) {
                $userlistkdo = $event->getData();
                $form = $event->getForm();

                if ($security->isGranted('ROLE_ADMIN') === false) {
                    $form->remove('user');
                    $userlistkdo->setUser($security->getToken()->getUser());
                }
            }
        );
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(
            array(
                'data_class' => 'AppBundle\Entity\UserListKdo',
                'attr' => array(
                    'class' => 'customerpanel'
                )
            )
        );
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'appbundle_userlistkdo_formtype';
    }
}
