<?php

namespace AdminBundle\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use AdminBundle\Form\CategoryType;
use AdminBundle\Form\QouiquiType;
use AdminBundle\Form\ScategoryType;
use AdminBundle\Form\QvilleNewType;


class NgnNewType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            // ->add('category', CategoryType::class, [])
            ->add('category', EntityType::class, array(
                'class' => 'AdminBundle:Category',
                'choice_label' => 'libelle',))

            //->add('qville', QvilleNewType::class, ['mapped' => false])
            ->add('qouiqui', QouiquiType::class,[])

            //->add('scategory',ScategoryType::class, [])
            ->add('scategory', EntityType::class, array(
                'class' => 'AdminBundle:Scategory',
                'choice_label' => 'libelle',))

            ->add('ville', EntityType::class, array(
                'class' => 'AdminBundle:Ville',
                'choice_label' => 'libelle',
                'mapped'=> false))

            ->add('delegation', EntityType::class, array(
                'class' => 'AdminBundle:Delegation',
                'choice_label' => 'libelle',
                'mapped'=> false))

            ->add('pays', EntityType::class, array(
                'class' => 'AdminBundle:Pays',
                'choice_label' => 'libelle',
                'mapped'=> false))



        ;
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AdminBundle\Entity\Ngn'

        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'adminbundle_ngn';
    }


}
