<?php

namespace AdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ImmobiliairType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('adresse')
            ->add('titre')
            ->add('prix')
            ->add('statu')
            ->add('cuisineEquipee')
            ->add('sallon')
            ->add('suits')
            ->add('salleDeBain')
            ->add('ascenseur')
            ->add('archive')
            ->add('equipment')
            ->add('details')
            ->add('prefix')

        ;
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AdminBundle\Entity\Immobiliair'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'adminbundle_immobiliair';
    }


}
