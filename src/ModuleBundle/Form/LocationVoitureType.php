<?php

namespace ModuleBundle\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;


class LocationVoitureType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('serie', TextType::class)
            ->add('modele', TextType::class)
            ->add('nbr_place', IntegerType::class)
            ->add('prix_jour', NumberType::class)
            ->add('statut', ChoiceType::class,['choices'=>['réservés'=>'reserves','Non réservés'=>'Non_reserves']])
            ->add('mark', EntityType::class,['class'=>'AdminBundle:Mark','choice_label'=>'name']);
    }


    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AdminBundle\Entity\LocationVoiture'
        ));
    }


}