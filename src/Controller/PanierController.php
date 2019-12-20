<?php


namespace App\Controller;


use App\Entity\Product;
use App\Service\PanierService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PanierController extends AbstractController
{
    /**
     * @var PanierService
     */
    private $panierService;

    public function __construct(PanierService $panierService)
    {
        $this->panierService = $panierService;
    }

    public function index() {
        $panierWithItems = [];
        $panier          = $this->panierService->getContenu();
        try {
            $prixTotal = $this->panierService->getTotal();
        } catch (\Exception $e) {
            throw $this->createNotFoundException($e->getMessage());
        }
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

    public function panierAjouter(int $productId)
    {
        try {
            $this->panierService->ajouterProduit($productId);
        } catch (\Exception $e) {
            throw $this->createNotFoundException($e->getMessage());
        }

        return $this->redirectToRoute('panier');
    }

    public function panierEnlever(int $productId)
    {
        try {
            $this->panierService->enleverProduit($productId);
        } catch (\Exception $e) {
            throw $this->createNotFoundException($e->getMessage());
        }

        return $this->redirectToRoute('panier');
    }

    public function panierSupprimer(int $productId)
    {
        try {
            $this->panierService->supprimerProduit($productId);
        } catch (\Exception $e) {
            throw $this->createNotFoundException($e->getMessage());
        }

        return $this->redirectToRoute('panier');
    }

    public function panierVider()
    {
        $this->panierService->vider();

        return $this->redirectToRoute('panier');
    }

    public function afficherNavbar()
    {
        $nbProduits = $this->panierService->getNbProduits();

        return $this->render(
            'panier/nbProduits_navbar.html.twig',
            [
                'nb_produits' => $nbProduits,
            ]
        );
    }

    public function afficherNbProduit(int $productId)
    {
        $nbProduit = $this->panierService->getNbProduit($productId);

        return $this->render(
            'panier/nbProduits_boutique.html.twig',
            [
                'nb_produit' => $nbProduit,
            ]
        );
    }

    public function validerPanier()
    {
        $this->panierService->panierToCommande($this->getUser());
        return $this->redirectToRoute('panier');
    }
}