<?php

namespace ModuleBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class HotelType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('typeRoom', ChoiceType::class, array('label' => 'Type des chambres',
            'choices' => array(
                "Chambre simple" => 1,
                "Chambre double" => 2,
                "Chambre triple" => 3,
                "Chambre familiale" => 4
            )))
            ->add('other', ChoiceType::class, array('label' => 'liste des services',
                'choices' => array(
                    "Taille de la pièce 350 FT2" => 1,
                    "Ordinateur" => 2,
                    "Superbe vue" => 3,
                    "WIFI" => 4,
                    "TV à écran plat" => 5,
                    "Climatisation" => 6,
                    "Insonoriser" => 7,
                    "Petit déjeuner inclus" => 7,
                    "Service de chambre" => 7,
                    "Ramassage de l'aéroport" => 7
                ),
                'multiple'  => true,
            ))
            ->add('descriptionRoom')
            ->add('imageServices', fileType::class, array('required' => false, 'label' => 'Image', 'data_class' => null))
            ->add('descriptionServices')
            ->add('imageNews', fileType::class, array('required' => false, 'label' => 'Image', 'data_class' => null))
            ->add('descriptionNews');
        //->add('qouiqui')        ;
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AdminBundle\Entity\Hotel'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'adminbundle_hotel';
    }


}
