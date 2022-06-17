<?php

namespace App\Form;

use App\Entity\Category;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class CategoryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [ 
                'label' => "Titre de la catégorie", 
                "attr" => ["placeholder" => "Titre de votre catégorie"]
            ])
            ->add('image', UrlType::class, [ 
                'label' => "Image de la catégorie", 
                "attr" => ["placeholder" => "Image de votre catégorie, veuillez mettre le lien ici"]
            ])
            ->add('banniere', UrlType::class, [ 
                'label' => "Banniere de la catégorie", 
                "attr" => ["placeholder" => "Bannière de votre catégorie, veuillez mettre le lien ici"]
            ])
            ->add('Envoyer', SubmitType::class);
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Category::class,
        ]);
    }
}
