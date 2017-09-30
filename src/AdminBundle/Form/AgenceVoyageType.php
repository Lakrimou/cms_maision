<?php

namespace AdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;;

class AgenceVoyageType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('offreName')
            ->add('prix')
            ->add('service')
            ->add('departPlace')
            ->add('retourPlace')
            ->add('dateDepart')
            ->add('dateRetour')
            ->add('cabine')
            ->add('nbrEscale')
            ->add('boatPlaneModel')
            ->add('qouiqui')
            ->add('type')
            ;
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AdminBundle\Entity\AgenceVoyage'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'AdminBundle_agencevoyage';
    }


}
