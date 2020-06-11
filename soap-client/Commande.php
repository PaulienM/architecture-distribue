<?php


namespace SoapClient;


class Commande
{
    /**
     * @var int
     */
    public $id;

    /**
     * @var string
     */
    public $statut;

    /**
     * @var string
     */
    public $dateCommande;

    /**
     * CommandSoap constructor.
     *
     * @param   int     $id
     * @param   string  $statut
     * @param   string  $dateCommande
     */
    public function __construct(int $id, string $statut, string $dateCommande)
    {
        $this->id           = $id;
        $this->statut       = $statut;
        $this->dateCommande = $dateCommande;
    }


    public function setId($id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStatut(): ?string
    {
        return $this->statut;
    }

    public function setStatut(string $statut): self
    {
        $this->statut = $statut;

        return $this;
    }

    public function getDateCommande()
    {
        return $this->dateCommande;
    }

    public function setDateCommande($dateCommande): self
    {
        $this->dateCommande = $dateCommande;

        return $this;
    }


}