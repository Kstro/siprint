<?php

namespace DG\ImpresionBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DetalleParametroType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nombre',null, array('attr'=>array('class'=>'input-sm form-control')))
            ->add('valor',null, array('attr'=>array('class'=>'input-sm form-control')))
//            ->add('parametro',null, array('attr'=>array('class'=>'input-sm form-control')))
            ->add('tipoParametro',null, array('attr'=>array('class'=>'input-sm form-control')))    
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'DG\ImpresionBundle\Entity\DetalleParametro'
        ));
    }
}
