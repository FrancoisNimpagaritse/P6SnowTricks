<?php

namespace App\Form;

use App\Entity\Figure;
use App\Form\VideoType;
use App\Entity\Category;
use App\Form\PictureType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class FigureType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('description')
            ->add('mainImg', FileType::class, ['label' =>  'Image principale', 'mapped' =>false, 'required' => false]) 
            ->add('category', EntityType::class, [
            'class' =>  Category::class,
            'choice_label'  =>  'name'
            ])
            ->add('pictures', CollectionType::class, ['label' =>'Images',
                'entry_type' => PictureType::class,
                'allow_add'  => true,
                'allow_delete' => true
            ])
            ->add('videos', CollectionType::class, [
                'entry_type' => VideoType::class,
                'allow_add'  => true,
                'allow_delete' => true
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Figure::class,
        ]);
    }
}
