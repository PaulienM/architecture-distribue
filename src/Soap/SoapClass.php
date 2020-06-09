<?php

namespace App\Soap;

use App\Entity\User;
use Doctrine\ORM\EntityManager;

class SoapClass
{
    private $em;

    public function __construct(EntityManager $entityManager)
    {
        $this->em = $entityManager;
    }

    /**
     * Dis "Hello" à la personne passée en paramètre
     * @param string $name Le nom de la personne à qui dire "Hello!"
     * @return string The hello string
     */
    public function sayHello(string $name) : string
    {
        return 'Hello '.$name.'!';
    }

    /**
     * Réalise la somme de deux entiers
     * @param int $a 1er nombre
     * @param int $b 2ème nombre
     * @return int La somme des deux entiers
     */
    public function sumHello(int $a, int $b) : int {
        return (int)($a+$b);
    }

    /**
     * Récupère un utilisateur par l'id
     * @param int $id L'id de l'utilisateur à récupérer
     * @return UserSoap
     */
    public function getUserById(int $id): UserSoap
    {
        $user = $this->em->getRepository(User::class)->findOneBy(["id" => $id]);

        return new UserSoap($user->getNom(), $user->getPrenom());
    }
}