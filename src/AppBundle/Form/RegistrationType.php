<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Vich\UploaderBundle\Form\Type\VichImageType;

class RegistrationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name', TextType::class, array('label' => false, 'attr' => array('class' => 'form-control', 'style' => 'margin-bottom:15px', 'placeholder' => 'Nom et Prénom')))
            ->add('description', TextareaType::class, array('label' => false, 'attr' => array('class' => 'form-control', 'style' => 'margin-bottom:15px', 'placeholder' => 'Apropos de vous...')))
            ->add('imageFile', VichImageType::class);
    }

    public function  getParent()
    {
        return 'FOS\UserBundle\Form\Type\RegistrationFormType';
    }

    public function getBlockPrefix()
    {
        return 'app_user_registration';
    }

    public function getName()
    {
        return $this->getBlockPrefix();
    }
}