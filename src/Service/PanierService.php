<?php


namespace App\Service;

use Symfony\Component\HttpFoundation\Session\SessionInterface;

class PanierService
{
    const PANIER_SESSION = 'panier';

    /**
     * @var SessionInterface $session
     */
    private $session;

    /**
     * @var BoutiqueService $boutiqueService
     */
    private $boutiqueService;

    /**
     * @var array $panier
     */
    private $panier;

    /**
     * PanierService constructor.
     *
     * @param SessionInterface $session
     * @param BoutiqueService  $boutiqueService
     */
    public function __construct(
        SessionInterface $session,
        BoutiqueService $boutiqueService
    ) {
        $this->session = $session;
        $this->boutiqueService = $boutiqueService;
        $this->panier = $this->session->get(self::PANIER_SESSION, []);
    }

    /**
     * @return array
     */
    public function getContenu(): array
    {
        return $this->session->get(self::PANIER_SESSION, []);
    }

    /**
     * @return float
     */
    public function getTotal(): float
    {
        $total = 0;
        foreach ($this->getContenu() as $id => $quantity) {
            $total += $this->boutiqueService->findProduitById($id)['prix'] * $quantity;
        }
        return $total;
    }

    /**
     * @return int
     */
    public function getNbProduits(): int
    {
        $nbProduits = 0;
        foreach ($this->getContenu() as $quantity) {
            $nbProduits += $quantity;
        }
        return $nbProduits;
    }

    public function getNbProduit(int $productId): int
    {
        if (isset($this->getContenu()[$productId])) {
            return $this->getContenu()[$productId];
        } else {
            return 0;
        }
    }

    /**
     * @param int $idProduit
     * @param int $quantity
     */
    public function ajouterProduit(int $idProduit, int $quantity = 1): void
    {
        if (isset($this->panier[$idProduit])) {
            $initialQuantity = $this->panier[$idProduit];
        } else {
            $initialQuantity = null;
        }
        if ($initialQuantity !== null) {
            $this->panier[$idProduit] += $quantity;
        } else {
            $this->panier[$idProduit] = $quantity;
        }
        $this->session->set(self::PANIER_SESSION, $this->panier);
    }

    /**
     * @param int $idProduit
     * @param int $quantity
     */
    public function enleverProduit(int $idProduit, int $quantity = 1): void
    {
        if (isset($this->panier[$idProduit])) {
            $initialQuantity = $this->panier[$idProduit];
        } else {
            $initialQuantity = 0;
        }
        if ($initialQuantity !== null && $initialQuantity > $quantity) {
            $this->panier[$idProduit] -= $quantity;
        } else {
            unset($this->panier[$idProduit]);
        }
        $this->session->set(self::PANIER_SESSION, $this->panier);
    }

    /**
     * @param int $idProduit
     */
    public function supprimerProduit(int $idProduit): void
    {
        unset($this->panier[$idProduit]);
        $this->session->set(self::PANIER_SESSION, $this->panier);
    }

    public function vider(): void
    {
        $this->panier = [];
        $this->session->set(self::PANIER_SESSION, $this->panier);
    }
}