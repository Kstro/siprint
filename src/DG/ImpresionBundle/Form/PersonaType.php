<?php

namespace DG\ImpresionBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PersonaType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nombres', null, array(
                    'attr'=>array(
                    'class'=>'form-control col-md-8'
                    )
                ))
            ->add('apellidos', null, array(
                    'attr'=>array(
                    'class'=>'form-control input-sm'
                    )
                ))
            ->add('direccion', null, array(
                    'attr'=>array(
                    'class'=>'form-control input-sm'
                    )
                ))
            //->add('telefono')
            //->add('estado')
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'DG\ImpresionBundle\Entity\Persona'
        ));
    }
}
