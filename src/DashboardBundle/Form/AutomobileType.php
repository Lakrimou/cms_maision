<?php

namespace DashboardBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class AutomobileType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('modelYear', DateType::class, array('label' => 'Année-modèle'))
            ->add('mark', TextType::class, array('label' => 'Marque'))
            ->add('model', TextType::class, array('label' => 'Modèle'))
            ->add('mileage', IntegerType::class, array('label' => 'Kilométrage'))
            ->add('energy', ChoiceType::class, array('label' => 'Energie',
                'choices' => array(
                    'Diesel' => 0,
                    'Essence' => 1,
                ),
            ))
            ->add('fiscalPower', IntegerType::class, array('label' => 'Puissance fiscal'))
            ->add('images', FileType::class, array('required' => false, 'label' => 'Image', 'data_class' => null))
            ->add('details', TextareaType ::class, array('label' => 'Détails'))
            ->add('other', TextareaType ::class, array('label' => 'Autres'))
            ->add('statut', ChoiceType::class, array('label' => 'Etat',
            'choices' => array(
                'Afficher' => 1,
                'Archiver' => 0,
            ),
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AdminBundle\Entity\Automobile'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'adminbundle_automobile';
    }


}
