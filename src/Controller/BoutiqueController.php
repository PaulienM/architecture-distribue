<?php


namespace App\Controller;


use App\Entity\Category;
use App\Entity\Product;
use App\Service\PanierService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class BoutiqueController extends AbstractController
{
    public function index()
    {
        $categoryList = $this->getDoctrine()->getRepository(Category::class)->findAll();
        if (!$categoryList) {
            throw $this->createNotFoundException('La categorie n\'existe pas');
        }

        return $this->render('boutique/index.html.twig', [
            "categories" => $categoryList
        ]);
    }

    public function rayon(PanierService $panierService, int $idCategory)
    {
        $products = $this->getDoctrine()->getRepository(Product::class)->findByCategory($idCategory);
        if (!$products) {
            throw $this->createNotFoundException('Le produit n\'existe pas');
        }

        return $this->render('boutique/rayon.html.twig', [
            "products" => $products
        ]);
    }

    public function search(Request $request)
    {
        $searchText = $request->get('search');
        $products = $this->getDoctrine()->getRepository(Product::class)
                         ->findAllMatchWithSearch($searchText);

        return $this->render('boutique/rayon.html.twig', [
            "products" => $products
        ]);
    }
}