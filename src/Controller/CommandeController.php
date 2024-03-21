<?php

namespace App\Controller;

use App\Entity\Produits;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ProduitsRepository;

class CommandeController extends AbstractController
{

    #[Route('/', name: 'index')]
    public function index(SessionInterface $session, ProduitsRepository $produitsRepository)
    {
        $panier = $session->get('panier', []);

        // On initialise des variables
        $data = [];
        $total = 0;

        foreach($panier as $id => $quantite){
            $produit = $produitsRepository->find($id);

            $data[] = [
                'produit' => $produit,
                'quantite' => $quantite
            ];
            $total += $produit->getPrixProduit() * $quantite;
        }
        
        return $this->render('commande/index.html.twig', compact('data', 'total'));
    }


    #[Route('/commande/{id}', name: 'app_commande')]
    public function add($id,ProduitsRepository $ProduitsRepository, SessionInterface $session)
    {
        //On récupère l'id du produit
        $produit = $ProduitsRepository->find($id);
        
       // $id = $ProduitsRepository->getId();
        // On récupère le panier existant
        $panier = $session->get('panier', []);

        // On ajoute le produit dans le panier s'il n'y est pas encore
        // Sinon on incrémente sa quantité
        if(empty($panier[$id])){
            $panier[$id] = 1;
        }else{
            $panier[$id]++;
        }

        $session->set('panier', $panier);

        //On redirige vers la page du panier
        
        return $this->redirectToRoute('index');

    }

   
    

    #[Route('/remove/{id}', name: 'remove')]
    public function remove($id,ProduitsRepository $ProduitsRepository, SessionInterface $session)
    {
        //On récupère l'id du produit
        $produit = $ProduitsRepository->find($id);
        $id = $produit->getId();

        // On récupère le panier existant
        $panier = $session->get('panier', []);

        // On retire le produit du panier s'il n'y a qu'1 exemplaire
        // Sinon on décrémente sa quantité
        if(!empty($panier[$id])){
            if($panier[$id] > 1){
                $panier[$id]--;
            }else{
                unset($panier[$id]);
            }
        }

        $session->set('panier', $panier);
        
        //On redirige vers la page du panier
        return $this->redirectToRoute('index');

        
    }



    #[Route('/delete/{id}', name: 'delete')]
    public function delete($id,ProduitsRepository $ProduitsRepository, SessionInterface $session)
    {
        //On récupère l'id du produit
        $produit = $ProduitsRepository->find($id);
        $id = $produit->getId();

        // On récupère le panier existant
        $panier = $session->get('panier', []);

        if(!empty($panier[$id])){
            unset($panier[$id]);
        }

        $session->set('panier', $panier);
        
        //On redirige vers la page du panier
        return $this->redirectToRoute('index');
    }

    #[Route('/empty', name: 'empty')]
    public function empty(SessionInterface $session)
    {
        $session->remove('panier');

        return $this->redirectToRoute('index');
    }
}



    
    

       
    
    

