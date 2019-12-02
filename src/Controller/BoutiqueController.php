<?php


namespace App\Controller;


use App\Service\BoutiqueService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class BoutiqueController extends AbstractController
{
    public function index(BoutiqueService $boutiqueService)
    {
        $categoryList = $boutiqueService->findAllCategories();
        return $this->render('boutique/index.html.twig', [
            "categories" => $categoryList
        ]);
    }

    public function rayon(BoutiqueService $boutiqueService, int $idCategory)
    {
        $products = $boutiqueService->findProduitsByCategorie($idCategory);
        return $this->render('boutique/rayon.html.twig', [
            "products" => $products
        ]);
    }

    public function search(BoutiqueService $boutiqueService, string $searchText)
    {
        $products = $boutiqueService->findProduitsByLibelleOrTexte($searchText);
        return $this->render('boutique/rayon.html.twig', [
            "products" => $products
        ]);
    }
}