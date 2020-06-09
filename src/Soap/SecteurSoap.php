<?php

namespace App\Soap;

use App\Entity\Secteur;

/**
 * Class SecteurSoap
 * @package App\Soap
 */
class SecteurSoap
{

    /**
     * @var int $id
     */
    public $id;
    /**
     * @var string $libelle
     */
    public $libelle;

    /**
     * SecteurSoap constructor.
     * @param int $id
     * @param string $libelle
     */
    public function __construct(int $id, string $libelle)
    {
        $this->id = $id;
        $this->libelle = $libelle;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(string $libelle): self
    {
        $this->libelle = $libelle;

        return $this;
    }

}