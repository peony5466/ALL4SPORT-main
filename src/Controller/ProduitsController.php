<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ProduitsRepository;
use App\Repository\RayonRepository;
use Doctrine\ORM\EntityManagerInterface;



class ProduitsController extends AbstractController
{
  private $entityManager;

  public function __construct(EntityManagerInterface $entityManager)
  {
      $this->entityManager = $entityManager;
  }
    #[Route('/produits', name: 'app_produits')]
    public function listeProduits(ProduitsRepository $ProduitsRepository, RayonRepository $RayonRepository): Response
    {
        $produits = $ProduitsRepository->findAll();
        $rayon = $RayonRepository->findAll();
        return $this->render('produits/liste.html.twig', [
            'controller_name' => 'ProduitsController',
            'produits' => $produits,
            'rayons' => $rayon
            
        ]);
    }

    #[Route('/detailsproduits/{id}', name: 'app_detailsproduits')]
    public function detailsProduits($id,ProduitsRepository $ProduitsRepository,RayonRepository $RayonRepository): Response
    {
      
        $produit = $ProduitsRepository->find($id);
    
        $photos = $produit->getPhotos();
        $rayon = $produit->getFkRayon();
        return $this->render('produits/details.html.twig', [
            'produit' => $produit,
            'photos' => $photos,
            'rayon' => $rayon 
            
        ]);
    }
    


}
