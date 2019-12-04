<?php


namespace App\Controller;


use App\Service\BoutiqueService;
use App\Service\PanierService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PanierController extends AbstractController
{
    public function index(PanierService $panierService, BoutiqueService $boutiqueService)
    {
        $session = $panierService->findAllProducts();
        $panier = [];
        foreach ($session as $key => $value) {
            $panier[] = [$boutiqueService->findProduitById($key), $value];
        }
        return $this->render(
            'panier/index.html.twig',
            [
                "panier" => $panier,
            ]
        );
    }

    public function addProduct(PanierService $panierService, $productId)
    {
        $panierService->addProduct($productId);
        return $this->redirectToRoute('panier');
    }
}