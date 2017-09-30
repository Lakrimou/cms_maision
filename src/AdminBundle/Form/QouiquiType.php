<?php

namespace AdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class QouiquiType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstName', TextType::class, [])
            ->add('lastName')
            ->add('address1')
            ->add('adress2')
            ->add('website')
            ->add('numRegistre')
            ->add('numPatente')
            ->add('shortDescription')
            ->add('zipCode')
            ->add('phone')
            ->add('phone2')
            ->add('mail')
            ->add('geoLat', HiddenType::class,[])
            ->add('geoLong', HiddenType::class,[])
            ->add('slug',null,array('attr'=> array('class'=>'slug','placeholder'=>'nom de votre site')))
            ->add('image',FileType::class,
                array(
                    'multiple' => true,
                    'label' => false,
                    'data_class' => null,
                    'required' => false,
                ))
        ;

    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AdminBundle\Entity\Qouiqui'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'adminbundle_qouiqui';
    }


}
