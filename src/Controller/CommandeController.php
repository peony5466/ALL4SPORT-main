<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ProduitsRepository;

class CommandeController extends AbstractController
{
    #[Route('/commande', name: 'app_commande')]
    public function ajouterAupanier(Request $request, ProduitsRepository $produitsRepository): Response
    {
        $produits = $produitsRepository->findAll();
        //$commande = $this->get('session')->get('commande', []);
        $session = $request->getSession();
        $commande = $session->set('commande', []);
        // Ajout produit
        $commande[] = $produits;
        //redirection 
        //return $this->redirectToRoute('app_commande');
        return $this->render('commande/ajouter.html.twig', [
            'produits' => $produits,
            'commande' => $commande
        ]);
       
    }

    #[Route('/addproduit', name: 'add_produit')]
    public function add(Request $request, EntityManagerInterface $em): Response
    {
        $produit = new produit();
        $produit->handleRequest($request);
        if ($commande->isSubmitted() && $commande->isValid()) {
            $produit = $commande->getData();
            // on sauvegarde en bdd
            $em->persist($produit);
            $em->flush(); // Execute en bdd les requetes sql (insert, update)
            return $this->redirectToRoute('app_commande');
        }
        return $this->render('commande/addproduit.html.twig', [
            'commande' => $commande
        ]);
    }
    
}
       
    
    

