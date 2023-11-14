<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\RayonRepository;
use App\Repository\ProduitsRepository;

class RayonController extends AbstractController
{
    #[Route('/rayon/{id}', name: 'app_rayon')]
    public function listeProduits( $id,ProduitsRepository $ProduitsRepository, RayonRepository $RayonRepository): Response
    {
        $produits = $ProduitsRepository->find($id);
        $rayon = $RayonRepository->findAll();
        return $this->render('rayon/index.html.twig', [
            'produits' => $produits,
            'rayons'=>$rayon
            
        ]);
    }
}
