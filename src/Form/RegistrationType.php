<?php

namespace App\Form;

use App\Entity\User;
use App\Form\ApplicationType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class RegistrationType extends ApplicationType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstname', TextType::class, $this->getAttributs("Prénom", "Votre prénom..."))
            ->add('lastname', TextType::class, $this->getAttributs("Nom","Votre nom de famille.."))
            ->add('email', EmailType::class, $this->getAttributs("Adresse email", "Votre adresse email.."))
            ->add('imgName', FileType::class, ['label' =>  'Photo', 'mapped' =>false, 'required' => false]) 
            ->add('hash', PasswordType::class, $this->getAttributs("Mot de passe", "Choisissez un mot de passe fort !"))
            ->add("passwordConfirm", PasswordType::class, $this->getAttributs("Confirmation mot de passe", "Veuillez confirmer votre mot de passe !"))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
