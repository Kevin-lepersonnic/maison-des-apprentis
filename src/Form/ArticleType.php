<?php

namespace App\Form;

use App\Entity\Article;
use App\Entity\Category;
use Symfony\Component\Form\AbstractType;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
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
            ->add('image', UrlType::class, [ 
                'label' => "Image de l'article", 
                "attr" => ["placeholder" => "Veuillez mettre le lien de l'image ici"]
            ])
            ->add('content', CKEditorType::class, [ 
                'label' => "Contenu de l'article", 
                "attr" => ["placeholder" => "Veuillez entrer votre contenu"]
            ])
            ->add('category', EntityType::class, [
                'class' => Category::class,
                'choice_label' => 'name',
                'label' => 'Catégorie de l\'article',
            ])
            ->add('support', FileType::class, [
                'label' => 'Document support (PDF, JPG, JPEG, PNG)',
                'mapped' => false,
                'required' => false,
                'constraints' => [
                    new File([
                        'maxSize' => '50000k',
                        'mimeTypes' => [
                            'application/pdf',
                            'application/x-pdf',
                            'application/jpg',
                            'application/jpeg',
                            'application/png',
                        ],
                        'mimeTypesMessage' => 'Merci d\'uploader un document valide',
                    ])
                ],
            ])
            
            ->add('Envoyer', SubmitType::class);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
        ]);
    }
}
