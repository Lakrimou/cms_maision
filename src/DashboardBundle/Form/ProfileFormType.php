<?php

namespace DashboardBundle\Form;

use FOS\UserBundle\Util\LegacyFormHelper;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class ProfileFormType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username', null, array('label' => 'form.username', 'translation_domain' => 'FOSUserBundle'))
            ->add('prenom', null, array('required' => true, 'label' => 'Prenom'))
            ->add('email', LegacyFormHelper::getType('Symfony\Component\Form\Extension\Core\Type\EmailType'), array('label' => 'form.email', 'translation_domain' => 'FOSUserBundle'))
            ->add('dateNaissance', BirthdayType::class, array('required' => true, 'label' => 'Date de naissance'
//                    'data' => new \DateTime("now")
            ))
            ->add('adress', null, array('required' => true, 'label' => 'Adresse'))
            ->add('phone_number', null, array('required' => true, 'label' => 'Numéro du téléphonne'))
            ->add('image', fileType::class, array('required' => false, 'label' => 'Image', 'data_class' => null));
    }

    /**
     * {@inheritdoc}
     */


}
