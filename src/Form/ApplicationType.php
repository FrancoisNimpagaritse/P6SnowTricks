<?php
 
namespace App\Form;

use Symfony\Component\Form\AbstractType;

class ApplicationType extends AbstractType
{
    /**
     * Permet de retourner les valeurs pour les attributs des champs
     *
     * @param string $label
     * @param string $placeholder
     * @return array
     */
    protected function getAttributs($label, $placeholder, $options = [])
    {
        return array_merge([
            'label' => $label,
            'attr'  => [
                'placeholder' => $placeholder
            ]
            ], $options);
    }
}