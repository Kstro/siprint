<?php

namespace DG\ImpresionBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DireccionType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', null, array(
                    'required'=>false,
                    'attr'=>array(
                    'class'=>'form-control input-sm'
                    )
                ))
            ->add('phoneNumber', null, array(
                    'required'=>false,
                    'attr'=>array(
                    'class'=>'form-control input-sm'
                    )
                ))   
            ->add('linea1', null, array(
                    'required'=>false,
                    'attr'=>array(
                    'class'=>'form-control input-sm'
                    )
                ))
            ->add('linea2', null, array(
                    'required'=>false,
                    'attr'=>array(
                    'class'=>'form-control input-sm'
                    )
                ))
            ->add('city', null, array(
                    'required'=>false,
                    'attr'=>array(
                    'class'=>'form-control input-sm'
                    )
                ))
            ->add('state', null, array(
                    'required'=>false,
                    'attr'=>array(
                    'class'=>'form-control input-sm'
                    )
                ))
            ->add('country', null, array(
                    'required'=>false,
                    'attr'=>array(
                    'class'=>'form-control input-sm'
                    )
                ))    
            ->add('zipCode', null, array(
                    'required'=>false,
                    'attr'=>array(
                    'class'=>'form-control input-sm'
                    )
                ))
            ->add('securityAccessCode', null, array(
                    'required'=>false,
                    'attr'=>array(
                    'class'=>'form-control input-sm'
                    )
                ))    
            ->add('defaultDir', null, array(
                    'attr'=>array(
                    'class'=>'form-control'
                    )
                ))
            //->add('usuario')
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'DG\ImpresionBundle\Entity\Direccion'
        ));
    }
}
