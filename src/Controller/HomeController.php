<?php

namespace App\Controller;

use App\Repository\CategoryRepository;
use App\Repository\RoleRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(CategoryRepository $categoryRepository, RoleRepository $roleRepository): Response
    {
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'categories' => $categoryRepository->findAll(),
            'role' => $roleRepository->findAll(),
        ]);
    }
}
