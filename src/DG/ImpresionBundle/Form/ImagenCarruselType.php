<?php

namespace DG\ImpresionBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ImagenCarruselType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
//            ->add('imagen')
//            ->add('carrusel')
                ->add('file',null, array('label'=>'Image','required'=>false,
                    'attr'=>array('class'=>'imagen'
                        
                    ))) 
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'DG\ImpresionBundle\Entity\ImagenCarrusel'
        ));
    }
}
