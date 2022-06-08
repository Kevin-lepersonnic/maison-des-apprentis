<?php

namespace App\Controller;

use App\Repository\ArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ArticleController extends AbstractController
{
    #[Route('/article', name: 'app_article')]
    public function index(ArticleRepository $articleRepository): Response
    {
        return $this->render('article/index.html.twig', [
            'articles' => $articleRepository->findAll(),
        ]);
    }

    #[Route('/articles/{slug}', name: 'article_show')]
    public function show($slug, ArticleRepository $articleRepository){
        $article = $articleRepository->findOneBySlug($slug);
        return $this->render('article/show.html.twig', ["article" => $article,]);
    }
}
