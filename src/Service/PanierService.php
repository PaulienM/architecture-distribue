<?php


namespace App\Service;

use Symfony\Component\HttpFoundation\Session\SessionInterface;

class PanierService
{
    /**
     * @var SessionInterface $session
     */
    private $session;

    /**
     * PanierService constructor.
     *
     * @param SessionInterface $session
     */
    public function __construct(SessionInterface $session)
    {
        $this->session = $session;
    }

    public function addProduct(int $productId)
    {
        $productNb = $this->session->get($productId);
        if ($productNb !== null) {
            $this->session->set($productId, $productNb++);
        } else {
            $this->session->set($productId, 1);
        }
    }

    public function removeOneProduct(int $productId)
    {
        $productNb = $this->session->get($productId);
        if ($productNb !== null) {
            $this->session->set($productId, $productNb--);
        }
    }

    public function removeAllOfOneProduct(int $productId)
    {
        if ($this->session->get($productId) !== null) {
            $this->session->remove($productId);
        }
    }

    public function removeAllProducts()
    {
        $this->session->clear();
    }

    public function findProductNb(int $productId)
    {
        return $this->session->get($productId);
    }

    public function findAllProducts()
    {
        return $this->session->all();
    }
}