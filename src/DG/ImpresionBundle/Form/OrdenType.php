<?php

namespace DG\ImpresionBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Doctrine\ORM\EntityRepository;

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
            ->add('cliente','entity',array('required'=>false,
                    'empty_value'   => 'Select an option...',
                    'class'=>'DGImpresionBundle:Cliente',
                    'query_builder' => function(EntityRepository $r) {
                        return $r->createQueryBuilder('s')
                                ->where('s.estado = 1')
                                ;   
                        } ,
                    'attr'=>array(
                        'class'=>'form-control input-sm'
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
