<?php


namespace App\Service;

use App\Entity\Commande;
use App\Entity\LigneCommande;
use App\Entity\User;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManager;
use Exception;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class PanierService
{
    const PANIER_SESSION = 'panier';

    /**
     * @var SessionInterface $session
     */
    private $session;

    /**
     * @var ProductRepository $repo
     */
    private $repo;

    /**
     * @var array $panier
     */
    private $panier;

    /**
     * @var EntityManager
     */
    private $em;

    /**
     * PanierService constructor.
     *
     * @param SessionInterface  $session
     * @param ProductRepository $repo
     */
    public function __construct(
        SessionInterface $session,
        ProductRepository $repo,
        EntityManager $em
    ) {
        $this->session = $session;
        $this->repo = $repo;
        $this->panier = $this->session->get(self::PANIER_SESSION, []);
        $this->em = $em;
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
     * @throws Exception
     */
    public function getTotal(): float
    {
        $total = 0;
        foreach ($this->getContenu() as $id => $quantity) {
            $this->verifierProduitExiste($id);
            $total += $this->repo->findOneById($id)->getPrix() * $quantity;
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
     *
     * @throws Exception
     */
    public function ajouterProduit(int $idProduit, int $quantity = 1): void
    {
        $this->verifierProduitExiste($idProduit);
        if (isset($this->panier[$idProduit])) {
            $this->panier[$idProduit] += $quantity;
        } else {
            $this->panier[$idProduit] = $quantity;
        }
        $this->session->set(self::PANIER_SESSION, $this->panier);
    }

    /**
     * @param int $idProduit
     * @param int $quantity
     *
     * @throws Exception
     */
    public function enleverProduit(int $idProduit, int $quantity = 1): void
    {
        $this->verifierProduitExiste($idProduit);
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
     *
     * @throws Exception
     */
    public function supprimerProduit(int $idProduit): void
    {
        $this->verifierProduitExiste($idProduit);
        unset($this->panier[$idProduit]);
        $this->session->set(self::PANIER_SESSION, $this->panier);
    }

    public function vider(): void
    {
        $this->panier = [];
        $this->session->set(self::PANIER_SESSION, $this->panier);
    }

    /**
     * @param int $productId
     *
     * @throws Exception
     */
    private function verifierProduitExiste(int $productId)
    {
        if (!$this->repo->findOneById($productId)) {
            throw new Exception('Le produit n\'existe pas');
        }
    }

    public function panierToCommande(User $user)
    {
        $contenu = $this->getContenu();
        if (!empty($contenu)) {
            $commande = new Commande();
            $commande->setDateCommande(new \DateTime());
            $commande->setUser($user);
            foreach ($contenu as $productId => $quantity) {
                $product = $this->repo->find($productId);
                if ($product) {
                    $ligneCommande = new LigneCommande();
                    $ligneCommande->setPrix($product->getPrix());
                    $ligneCommande->setProduct($product);
                    $ligneCommande->setQuantite($quantity);
                    $commande->addLigneCommande($ligneCommande);
                    $this->em->persist($ligneCommande);
                }
            }
            $this->em->persist($commande);
            $this->em->flush();
            $this->vider();
        }
    }
}