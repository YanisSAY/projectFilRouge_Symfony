<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/user')]
class UserController extends AbstractController
{
    #[Route('/', name: 'app_user_index', methods: ['GET'])]
    public function index(UserRepository $userRepository): Response
    {
        return $this->render('user/indexUser.html.twig');
    }

    #[Route('/new', name: 'app_user_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, UserPasswordHasherInterface $uphi): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Hasher le mdp
                // récupérer le mot de passe à partir di form
                $user = $form->getData();
                $mdp = $user->getPassword();
                $mdp = $uphi->hashPassword($user, $mdp);
                // remettre le mdp dans l'objet user
                $user->setPassword($mdp);
            // Récupérer photo et réinitialiser le chemin
            $chemin = "assets/images/user";
            $fichier = $form['photo']->getData();
            $fichier->move($chemin, $fichier->getClientOriginalName());
            $user->setPhoto("assets/images/user" . "/" . $fichier->getClientOriginalName());
            // Sauvegarde dans la BDD
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('app_login', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('user/newUser.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_user_show', methods: ['GET'])]
    public function show(User $user): Response
    {
        return $this->render('user/showUser.html.twig', [
            'user' => $user,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_user_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, User $user, EntityManagerInterface $entityManager, UserPasswordHasherInterface $uphi): Response
    {   
        $user->setPhoto(null);
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Hasher le mdp
                // récupérer le mot de passe à partir di form
                $user = $form->getData();
                $mdp = $user->getPassword();
                $mdp = $uphi->hashPassword($user, $mdp);
                // remettre le mdp dans l'objet user
                $user->setPassword($mdp);
                // Récupérer photo et réinitialiser le chemin
            $chemin = "assets/images/user";
            $fichier = $form['photo']->getData();
            $fichier->move($chemin, $fichier->getClientOriginalName());
            $user->setPhoto("assets/images/user" . "/" . $fichier->getClientOriginalName());
            
            // Ajout dans la BDD
            $entityManager->flush();

            return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('user/editUser.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_user_delete', methods: ['POST'])]
    public function delete(Request $request, User $user, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->getPayload()->get('_token'))) {
            $entityManager->remove($user);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
    }
}
