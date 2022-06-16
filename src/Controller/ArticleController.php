<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Article;
use App\Form\ArticleType;
use App\Service\FileUploader;
use App\Repository\ArticleRepository;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

class ArticleController extends AbstractController
{
    #[Route('/article', name: 'app_article')]
    public function index(ArticleRepository $articleRepository, CategoryRepository $categoryRepository): Response
    {
        return $this->render('article/index.html.twig', [
            'articles' => $articleRepository->findAll(),
            'categories' => $categoryRepository->findAll(),
        ]);
    }


    #[Route('/articles/new', name: 'article_create')]
    public function create(Request $request, EntityManagerInterface $manager, FileUploader $fileUploader, CategoryRepository $categoryRepository){

        $article = new Article();

        $form = $this->createForm(ArticleType::class, $article);

        $form->handleRequest($request);

            if ( $form->isSubmitted() && $form->isValid() ) {
                
                $article->setAuthor($this->getUser());
                $supportFile = $form->get('support')->getData();
                if ($supportFile) {
                    $supportFileName = $fileUploader->upload($supportFile);
                    $article->setSupportFilename($supportFileName);
                }

                $manager->persist($article);
                $manager->flush();
                
                $this->addFlash("success", "L'article <strong>{$article->getTitle()}</strong> a bien été crée");

                return $this->redirectToRoute('article_show', [
                    'slug' => $article->getSlug(),
                 ]);
            }

        return $this->render('article/create.html.twig', [
            'form' => $form->createView(),
            'categories' => $categoryRepository->findAll(),
        ]);
    }

    #[Route('/articles/{id}', name: 'app_article_cat')]
    public function showCat( $id, ArticleRepository $articleRepository, CategoryRepository $categoryRepository){
    
        
        $categoryName = $categoryRepository->findOneById($id);
        $article = $articleRepository->findBy(array('category' => $categoryName));
        
        return $this->render('article/indexbycat.html.twig', [
            'articles' => $article,
            'categories' => $categoryRepository->findAll(),
            'categorie' =>$categoryName,
        ]);
        
    }

    #[Route('/articles/{slug}', name: 'article_show')]
    public function show($slug, ArticleRepository $articleRepository, CategoryRepository $categoryRepository){
        $article = $articleRepository->findOneBySlug($slug);
        return $this->render('article/show.html.twig', [
            "article" => $article,
            'categories' => $categoryRepository->findAll(),
        ]);
    }

    #[Route('/articles/{slug}/edit', name: 'article_edit')]
    #[Security("is_granted('ROLE_ADMIN') || is_granted('ROLE_USER') and user === article.getAuthor()")]
    public function edit(Request $request, Article $article, EntityManagerInterface $manager, CategoryRepository $categoryRepository)
    {
        $form = $this->createForm(ArticleType::class, $article);

        $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {

                $manager->persist($article);
                $manager->flush();

                $this->addFlash('info', "L'article <strong>{$article->getTitle()}</strong> a bien été modifié");

                return $this->redirectToRoute('article_show' , [
                    'slug' => $article->getSlug()
                ]);
            }

        return $this->render('article/edit.html.twig', [
            'article' => $article,
            'form' => $form->createView(),
            'categories' => $categoryRepository->findAll(),
        ]);
    }

    #[Route('/articles/{slug}/delete', name: 'article_delete')]
    #[Security("is_granted('ROLE_ADMIN') || is_granted('ROLE_USER') and user === article.getAuthor()")]
    public function delete(EntityManagerInterface $manager, Article $article)
    {
        $manager->remove($article);
        $manager->flush();

        $this->addFlash('danger',"L'article a bien été supprimé");
      
        return $this->redirectToRoute('app_article');
    }

   
}