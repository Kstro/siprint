<?php

namespace DG\ImpresionBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Doctrine\ORM\EntityRepository;

class CategoriaType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
//            ->add('option','choice',array('required'=>false,
//                'mapped'  =>false,
//                'multiple'=>false,
//                'expanded'=>true,
//                'choices'  => array('cat' => 'Category', 'prod' => 'Product'),
//                'attr'=>array(
//                    'class'=>'parametros radio-inline'
//                )))    
            ->add('nombre', null, array(
                    'required'=>false,
                   'attr'=>array(
                    'class'=>'form-control'
                    )))
            ->add('categoria','entity',array('required'=>false,
                    'empty_value'   => 'Select an option...',
                    'class'=>'DGImpresionBundle:Categoria',
                    'query_builder' => function(EntityRepository $r) {
                        return $r->createQueryBuilder('s')
                                ->where('s.categoria is NULL')
                                ->andWhere('s.estado = 1')
                                ->andWhere('s.id <> 38')
                               //->setParameter('cat', NULL)
                                ;   
                        } ,
                    'attr'=>array(
                        'class'=>'form-control input-sm'
                     )            
                    ))
//            ->add('parametro','entity',array('required'=>false,
//                'class'=>'DGImpresionBundle:Parametro','property'=>'nombre',
//                'multiple'=>true,
//                'expanded'=>true,
//                
//                    'attr'=>array(
//                    'class'=>'parametros'
//                    )))
            ->add('file',null, array(
                    'required' => false,
                    'attr'=>array('class'=>'Product'
                 )))    
//            ->add('categoriaproducto','collection',array(
//                'type' => new CategoriaProductoType(),
//                'label'=>' ',
//                'by_reference' => false,
//                'allow_add' => true,
//                'allow_delete' => true,
//                ))   
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'DG\ImpresionBundle\Entity\Categoria'
        ));
    }
}
