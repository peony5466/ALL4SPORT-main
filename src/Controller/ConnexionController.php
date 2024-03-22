<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Client;
use App\Form\ConnexionType;

class ConnexionController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/connexion', name: 'app_connexion')]
    public function index(Request $request, AuthenticationUtils $authenticationUtils): Response
    {
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();

        $form = $this->createForm(ConnexionType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $email = $data['email'];
            $password = $data['mdp'];

            // Trouver l'utilisateur par son email
            $userRepository = $this->entityManager->getRepository(Client::class);
            $user = $userRepository->findOneBy(['email' => $email]);

            // Vérifier si l'utilisateur existe
            if ($user) {
                // Vérifier le mot de passe
                if (password_verify($password, $user->getMdp())) {
                    // Connexion réussie
                    // Ajouter un message de succès
                    $this->addFlash('success', 'Connexion réussie ! Bienvenue ' . $user->getNom());
                    // Rediriger l'utilisateur vers une page sécurisée
                    return $this->redirectToRoute('security/login.html.twig');
                } else {
                    // Mot de passe incorrect
                    $this->addFlash('error', 'Mot de passe incorrect');
                }
            } else {
                // Utilisateur non trouvé
                $this->addFlash('error', 'Aucun utilisateur trouvé avec cet email');
            }
        }

        return $this->render('security/login.html.twig', [
            'form' => $form->createView(),
            'error' => $error,
            'last_username' => $lastUsername,
        ]);
    }
}