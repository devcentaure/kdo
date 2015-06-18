<?php

namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Security\Core\SecurityContext;

class KdoType extends AbstractType
{

    private $kdoManager;

    private $security;

    public function  __construct($kdoManager, SecurityContext $securityContext)
    {
        $this->kdoManager = $kdoManager;

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
            ->add('name', null, array('label' => 'entity.kdo.name'))
            ->add('description', null, array('label' => 'entity.kdo.description', 'required' => false))
            ->add('link', null, array('label' => 'entity.kdo.link', 'required' => false))
            ->add('secondHand', 'choice', array(
                'label' => 'entity.kdo.second_hand',
                'choices' => array(
                    true => 'entity.kdo.second_hand_yes',
                    false => 'entity.kdo.second_hand_no'
                ),
            ))
            ->add('quantity', null, array('label' => 'entity.kdo.quantity'))
            ->add('price', null, array('label' => 'entity.kdo.price'));

        $builder->addEventListener(
            FormEvents::PRE_SET_DATA,
            function (FormEvent $event) use ($security) {
                $kdo = $event->getData();
                $form = $event->getForm();

                if ($security->isGranted('ROLE_ADMIN') === true) {
                    $form->add('listkdo');
                }

                $tmpFileName = '';
                $methodName = 'getWebIcon';
                if ($kdo->getId() !== null) {
                    $tmpFileName = $kdo->$methodName();
                }
                $form->add(
                    'fileIcon',
                    'zimzim_toolsbundle_zimzimimage',
                    array(
                        'label' => 'entity.kdo.icon',
                        'attr' => array(
                            'url' => $tmpFileName,
                            'label-inline' => 'label-inline'
                        )
                    )
                );
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
                'data_class' => $this->kdoManager->getClassName(),
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
        return 'appbundle_kdo_formtype';
    }
}
