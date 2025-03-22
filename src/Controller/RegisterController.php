<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RegisterController extends AbstractController
{
    #[Route('/register', name: 'app_register')]
public function register(Request $request, EntityManagerInterface $entityManager): Response
{
    $user = new User();
    $form = $this->createForm(UserType::class, $user);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        $entityManager->persist($user);
        $entityManager->flush();

        // ✅ Redirection vers la page de confirmation
        return $this->redirectToRoute('registration_confirmation');
    }

    return $this->render('register/index.html.twig', [
        'form' => $form->createView(),
    ]);
}
 

    #[Route('/confirmation', name: 'registration_confirmation')]
public function confirmation(): Response
{
    return $this->render('register/confirmation.html.twig');
}

}