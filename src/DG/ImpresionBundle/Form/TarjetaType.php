<?php

namespace DG\ImpresionBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TarjetaType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('numero', null, array(
                    'attr'=>array(
                    'class'=>'form-control input-sm'
                    )
                ))
            ->add('nombre', null, array(
                    'attr'=>array(
                    'class'=>'form-control input-sm'
                    )
                ))
            ->add('cvc', null, array(
                    'attr'=>array(
                    'class'=>'form-control input-sm'
                    )
                ))
            ->add('expiracion', null,
                  array('required'=>false,
                        'widget' => 'single_text',
                        'attr'   => array('class' => 'form-control input-md calZebra'),
                        'format' => 'MM-yyyy-dd',
                       ))
        //    ->add('usuario')
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'DG\ImpresionBundle\Entity\Tarjeta'
        ));
    }
}
