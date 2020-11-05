<?php

namespace App\Form;

use App\Form\ApplicationType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class PasswordUpdateType extends ApplicationType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('oldPassword', PasswordType::class, $this->getAttributs("Ancien mot de passe", "Votre mot de passe actuel"))
            ->add('newPassword', PasswordType::class, $this->getAttributs("Nouveau mot de passe", "Choisissez un mot de passe fort !"))
            ->add('confirmPassword', PasswordType::class, $this->getAttributs("Confirmation mot de passe", "Confirmez votre mot de passe !"))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
