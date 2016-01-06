<?php

namespace DG\ImpresionBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use DG\ImpresionBundle\Form\PersonaType;

class UsuarioType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username', null, array(
                    'attr'=>array(
                    'class'=>'form-control input-sm'
                    )
                ))
            ->add('password','repeated', array(
                    'type' => 'password',
                    'invalid_message' => 'The password is not the same',
                    'options' => array('attr' => array('class' => 'password-field')),
                    'required' => false,
                    'first_options'  => array('label' => 'Password','required'=>false,
                    'attr'=>array(
                    'class'=>'form-control input-sm firstPassword'
                    )),
                    'second_options' => array('label' => 'Confirm password','required'=>false,
                    'attr'=>array(
                    'class'=>'form-control input-sm secondPassword'
                    )),
                ))
            ->add('email', null, array(
                    'attr'=>array(
                    'class'=>'form-control input-sm'
                    )
                ))   
            ->add('persona', new PersonaType())
            ->add('user_roles','entity',array('label' => 'Select a role','required'=>false,
                'class'=>'DGImpresionBundle:Rol','property'=>'nombre',
                'multiple'=>true,
                'expanded'=>true,
                    'attr'=>array(
                    'class'=>'roles'
                    )))
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'DG\ImpresionBundle\Entity\Usuario'
        ));
    }
}
