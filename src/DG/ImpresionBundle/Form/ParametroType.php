<?php

namespace DG\ImpresionBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ParametroType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nombre',null, array('attr'=>array('class'=>'form-control input-sm')))
//            ->add('parametro')
            ->add('tipoCategoria',null, array('attr'=>array('class'=>'form-control input-sm')))
//            ->add('categoria')
//            ->add('detalleCategoria')
//            ->add('formatoPlantilla')
//            ->add('detalleparametro',new DetalleParametroType())
                
            ->add('coleccion','collection',array(
                'type' => new DetalleParametroType(),
                'label'=>' ',
                'by_reference' => false,
                'allow_add' => true,
                'allow_delete' => true,
                ))    
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'DG\ImpresionBundle\Entity\Parametro'
        ));
    }
}
