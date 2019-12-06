<?php


namespace App\Controller;


use App\Service\BoutiqueService;
use App\Service\PanierService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class BoutiqueController extends AbstractController
{
    public function index(BoutiqueService $boutiqueService)
    {
        $categoryList = $boutiqueService->findAllCategories();
        return $this->render('boutique/index.html.twig', [
            "categories" => $categoryList
        ]);
    }

    public function rayon(BoutiqueService $boutiqueService, PanierService $panierService, int $idCategory)
    {
        $products = $boutiqueService->findProduitsByCategorie($idCategory);
        $productWithCart = [];
        foreach ($products as $product) {
            $product['cart'] = $panierService->findProductNb($product['id']);
            $productWithCart[] = $product;
        }
        return $this->render('boutique/rayon.html.twig', [
            "products" => $productWithCart
        ]);
    }

    public function search(BoutiqueService $boutiqueService, Request $request)
    {
        $searchText = $request->get('search');
        $products = $boutiqueService->findProduitsByLibelleOrTexte($searchText);
        return $this->render('boutique/rayon.html.twig', [
            "products" => $products
        ]);
    }
}