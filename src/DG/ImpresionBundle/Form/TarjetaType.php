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
                    'required'=>false,
                    'attr'=>array(
                    'class'=>'form-control input-sm'
                    )
                ))
            ->add('nombre', null, array(
                    'required'=>false,
                    'attr'=>array(
                    'class'=>'form-control input-sm'
                    )
                ))
            ->add('cvc', null, array(
                    'required'=>false,
                    'attr'=>array(
                    'class'=>'form-control input-sm'
                    )
                ))
            ->add('expiracion', null,
                  array('required'=>false,
                        'widget' => 'single_text',
                        'attr'   => array('class' => 'form-control input-sm calZebra'),
                        'format' => 'MM-dd-yyyy',
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
