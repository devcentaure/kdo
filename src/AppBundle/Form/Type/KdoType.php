<?php

namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class KdoType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', null, array('label' => 'entity.kdo.name'))
            ->add('description', null, array('label' => 'entity.kdo.description'))
            ->add('quantity', null, array('label' => 'entity.kdo.quantity'))
            ->add('link', null, array('label' => 'entity.kdo.link'))
            ->add('price', null, array('label' => 'entity.kdo.price'))
            ->add('listkdo', null, array('label' => 'entity.kdo.listkdo', 'empty_value' =>  false))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Kdo',
            'attr' => array(
                'class' => 'customerpanel'
            )
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'appbundle_kdo_formtype';
    }
}
