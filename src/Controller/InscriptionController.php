<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Client;
use App\Form\InscriptionType;
use Doctrine\ORM\EntityManagerInterface;

class InscriptionController extends AbstractController
{
    #[Route('/inscription', name: 'app_inscription')]
    public function index(Request $request, EntityManagerInterface $entityManager): Response
    {
        $client = new Client();
        $form = $this->createForm(InscriptionType::class, $client);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Enregistrer le client dans la base de données sans sécuriser le mot de passe
            $entityManager->persist($client);
            $entityManager->flush();

            // Rediriger vers la page de connexion
            $this->addFlash('success', 'Inscription réussie. Vous pouvez maintenant vous connecter.');
            return $this->redirectToRoute('app_connexion');
        }

        return $this->render('inscription/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
