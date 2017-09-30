<?php

namespace AdminBundle\Form;

use Doctrine\DBAL\Types\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class annonceType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title',TextType::class , array('label' => false,'attr'=>array('class'=>'form-control','placeholder'=>'Titre d\'annonce') ))
            ->add('description',CKEditorType::class, array('label'=>false,'config' => array('uiColor' => '#ffffff')))
            ->add('prix',DoubleType::class,array('label'=>false,'attr'=>array('class'=>'form-control','placeholder'=>'Prix d\'annonce ')))



        ;
    }
    


    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'Ecommerce_service';
    }


}
