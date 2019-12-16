<?php


namespace App\Controller;


use App\Entity\Product;
use App\Service\BoutiqueService;
use App\Service\PanierService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PanierController extends AbstractController
{
    public function index(
        PanierService $panierService
    ) {
        $panierWithItems = [];
        $panier          = $panierService->getContenu();
        $prixTotal       = $panierService->getTotal();
        foreach ($panier as $id => $quantity) {
            $panierWithItems[] = [
                'item' => $this->getDoctrine()->getRepository(
                    Product::class
                )->findOneById($id),
                'quantity' => $quantity,
            ];
        }

        return $this->render(
            'panier/index.html.twig',
            [
                "panier" => $panierWithItems,
                "prix"   => $prixTotal,
            ]
        );
    }

    public function panierAjouter(PanierService $panierService, $productId)
    {
        $panierService->ajouterProduit($productId);

        return $this->redirectToRoute('panier');
    }

    public function panierEnlever(PanierService $panierService, $productId)
    {
        $panierService->enleverProduit($productId);

        return $this->redirectToRoute('panier');
    }

    public function panierSupprimer(PanierService $panierService, $productId)
    {
        $panierService->supprimerProduit($productId);

        return $this->redirectToRoute('panier');
    }

    public function panierVider(PanierService $panierService)
    {
        $panierService->vider();

        return $this->redirectToRoute('panier');
    }

    public function afficherNavbar(PanierService $panierService)
    {
        $nbProduits = $panierService->getNbProduits();

        return $this->render(
            'panier/nbProduits_navbar.html.twig',
            [
                'nb_produits' => $nbProduits,
            ]
        );
    }

    public function afficherNbProduit(
        PanierService $panierService,
        int $productId
    ) {
        $nbProduit = $panierService->getNbProduit($productId);

        return $this->render(
            'panier/nbProduits_boutique.html.twig',
            [
                'nb_produit' => $nbProduit,
            ]
        );
    }
}