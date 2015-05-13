<?php

namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Security\Core\SecurityContext;


class UserKdoType extends AbstractType
{

    private $userKdoManager;

    private $security;

    public function  __construct($userKdoManager, SecurityContext $securityContext)
    {
        $this->userKdoManager = $userKdoManager;

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
            ->add(
                'userShare',
                null,
                array(
                    'label' => 'entity.userkdo.usershare',
                    'required' => false
                )
            )
            ->add(
                'auction',
                'choice',
                array(
                    'label' => 'entity.userkdo.auction.label',
                    'choices' => array(
                        true => 'entity.userkdo.auction.choice1',
                        false => 'entity.userkdo.auction.choice2'
                    )
                )
            );

        $builder->addEventListener(
            FormEvents::PRE_SET_DATA,
            function (FormEvent $event) use ($security) {
                $userkdo = $event->getData();
                $form = $event->getForm();

                if ($security->isGranted('ROLE_ADMIN') === true) {
                    $form->add('user', null, array('label' => 'entity.userkdo.user'));
                } else {
                    $userkdo->setUser($security->getToken()->getUser());
                }

                if ($userkdo->getKdo() === null) {
                    $form->add('kdo', null, array('label' => 'entity.userkdo.kdo'));
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
                'data_class' => 'AppBundle\Entity\UserKdo',
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
        return 'appbundle_userkdo_formtype';
    }
}
