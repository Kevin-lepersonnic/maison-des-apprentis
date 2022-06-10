<?php

namespace App\Form;

use App\Entity\Article;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [ 
                'label' => "Titre de l'article", 
                "attr" => ["placeholder" => "votre titre ici"]
            ])
            ->add('image', TextType::class, [ 
                'label' => "Image", 
                "attr" => ["placeholder" => "Veuillez mettre le lien de l'image ici"]
            ])
            ->add('content', TextareaType::class, [ 
                'label' => "Contenu de l'article", 
                "attr" => ["placeholder" => "Veuillez entrer votre contenu"]
            ])
            ->add('Envoyer', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
        ]);
    }
}
