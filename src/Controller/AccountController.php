<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\AccountType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class AccountController extends AbstractController
{
    #[Route('/login', name: 'account_login')]
    public function login(AuthenticationUtils $utils)
    {
        $error = $utils->getLastAuthenticationError();
        $username = $utils->getLastUsername();

        dump($error, $username);

        return $this->render('account/login.html.twig', [
            'hasError' => $error !==null,
            'username' => $username
            
        ]);
    }

    #[Route('/logout', name: 'account_logout')]
    public function logout()
    {
       
    }

    #[Route('/account', name: 'app_account')]
    public function index(UserRepository $userRepository): Response
    {
        return $this->render('account/index.html.twig', [
            'users' => $userRepository->findAll(),
        ]);
    }

    #[Route('/account/new', name: 'user_create')]
    public function create(Request $request, EntityManagerInterface $manager, UserPasswordHasherInterface $encoder){

            $user= new User();
            $form = $this->createForm(AccountType::class,$user);
            $form->handleRequest($request);

            if($form->isSubmitted() && $form->isValid()){
                $hash = $encoder->hashPassword($user, $user->getHash());
                $user->setHash($hash);

                $manager->persist($user);
                $manager->flush();

                $this->addFlash("success","Bienvenue <strong>{$user->getFullname()}</strong>, votre compte a bien été créé");

                return $this->redirectToRoute('user_show',[
                    'slug' => $user->getSlug()]);
            }

        return $this->render('account/create.html.twig', [
            'form'=> $form->createView()
        ]);
    }

    
    #[Route('/account/{slug}/edit', name: 'user_edit')]
    public function edit(Request $request, User $user, EntityManagerInterface $manager, UserPasswordHasherInterface $encoder)
    {
        $form = $this->createForm(AccountType::class, $user);
        $form->handleRequest($request);

            if($form->isSubmitted() && $form->isValid()){

                $hash = $encoder->hashPassword($user, $user->getHash());
                $user->setHash($hash);

                $manager->flush();

                $this->addFlash("info","Votre compte <strong>{$user->getFullname()}</strong> a bien été modifié");

                return $this->redirectToRoute('user_show',[
                    'slug' => $user->getSlug()]);
            }

        return $this->render('account/edit.html.twig', [
            'user' => $user,
            'form'=> $form->createView()
        ]);

    }

    #[Route('/account/{slug}/delete', name: 'user_delete')]
    public function delete(User $user, EntityManagerInterface $manager)
    {
        $manager->remove($user);
        $manager->flush();

        $this->addFlash("danger","Votre compte a bien été supprimé");


        return $this->redirectToRoute('app_account');

    }

    #[Route('/account/{slug}', name: 'user_show')]
    public function show($slug, UserRepository $userRepository)
    {        
        $user = $userRepository->findOneBySlug($slug);
        return $this->render('account/show.html.twig', [
            'user' => $user,
        ]);
    }

}
