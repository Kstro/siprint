<?php

namespace DG\ImpresionBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OrdenType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            //->add('nombreProyecto')
            ->add('cliente', null, array(
                    'attr'=>array(
                    'class'=>'form-control'
                    )
                ))    
            ->add('direccionEnvio', null, array(
                    'attr'=>array(
                    'class'=>'form-control'
                    )
                ))
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'DG\ImpresionBundle\Entity\Orden'
        ));
        
        
    }
}
