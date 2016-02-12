<?php

namespace DG\ImpresionBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PromocionType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nombre', null, array(
                'required'=>false,
                ))
            ->add('codigo', null, array(
                'required'=>false,
                ))    
            ->add('porcentaje', null, array(
                'required'=>false,
                ))
            ->add('file',null, array(
                    //'label'=>'Photo promotion',
                    'required'=>false,
                    'required' => false,
                    'attr'=>array('class'=>'Promocion'
                    )))    
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'DG\ImpresionBundle\Entity\Promocion'
        ));
    }
}
