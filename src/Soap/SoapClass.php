<?php

namespace App\Soap;

use App\Entity\Commande;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Common\Collections\Collection;

class SoapClass
{
    private $em;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->em = $entityManager;
    }

    /**
     * Dis "Hello" à la personne passée en paramètre
     *
     * @param   string  $name  Le nom de la personne à qui dire "Hello!"
     *
     * @return string The hello string
     */
    public function sayHello(string $name): string
    {
        return 'Hello '.$name.'!';
    }

    /**
     * Réalise la somme de deux entiers
     *
     * @param   int  $a  1er nombre
     * @param   int  $b  2ème nombre
     *
     * @return int La somme des deux entiers
     */
    public function sumHello(int $a, int $b): int
    {
        return (int)($a + $b);
    }

    /**
     * Récupère un utilisateur par l'id
     *
     * @param   int  $id  L'id de l'utilisateur à récupérer
     *
     * @return \App\Soap\UserSoap
     */
    public function getUserById(int $id): \App\Soap\UserSoap
    {
        $user = $this->em->getRepository(User::class)->findOneBy(["id" => $id]);

        return new UserSoap(
            $user->getId(), $user->getNom(), $user->getPrenom()
        );
    }

    /**
     * Récupére la première commande d'un utilisateur à partir de son id
     *
     * @param   int  $id
     *
     * @return \App\Soap\CommandeSoap
     */
    public function getFirstCommandByUserId(int $id): \App\Soap\CommandeSoap
    {
        $user = $this->em->getRepository(User::class)->findOneBy(["id" => $id]);

        /** @var Collection $commandes */
        $commandes = $user->getCommandes();

        /** @var Commande $firstCommande */
        $firstCommande = $commandes->first();

        return new CommandeSoap(
            $firstCommande->getId(),
            $firstCommande->getStatut(),
            date_format($firstCommande->getDateCommande(), 'd/m/Y H:i:s')
        );
    }
}