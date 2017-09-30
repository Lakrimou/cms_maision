<?php

namespace UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * Description of RegistrationPatientType
 *
 * @author Maher
 */
class RegistrationPatientType extends AbstractType {
    public function buildForm(FormBuilderInterface $builder, array $options) {
//        $builder->add('name');
        //$builder->remove('username');

//die();
    }

    public function getParent() {
        return 'FOS\UserBundle\Form\Type\RegistrationFormType';

        // Or for Symfony < 2.8
        // return 'fos_user_registration';
    }

    public function getBlockPrefix() {
        return 'app_user_registration';
    }

    // For Symfony 2.x
//    public function getName() {
//        return $this->getBlockPrefix();
//    }

}
