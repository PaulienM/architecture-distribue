<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class ProductFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $fruits = new Category();
        $fruits->setLibelle("Fruits")
                 ->setVisuel("images/fruits.jpg")
                 ->setTexte("De la passion ou de ton imagination");
        $manager->persist($fruits);

        $junkFood = new Category();
        $junkFood->setLibelle("Junk Food")
                 ->setVisuel("images/junk_food.jpg")
                 ->setTexte("Chère et cancérogène, tu es prévenu(e)");
        $manager->persist($junkFood);

        $legumes = new Category();
        $legumes->setLibelle("Légumes")
                 ->setVisuel("images/legumes.jpg")
                 ->setTexte("Plus tu en manges, moins tu en es un");
        $manager->persist($legumes);

        $product = new Product();
        $product->setLibelle("Pomme")
                ->setTexte("Elle est bonne pour la tienne")
                ->setVisuel("images/pommes.jpg")
                ->setPrix(3.42)
                ->setCategory($fruits);
        $manager->persist($product);

        $product = new Product();
        $product->setLibelle("Poire")
                ->setTexte("Ici tu n'en es pas une")
                ->setVisuel("images/poires.jpg")
                ->setPrix(2.11)
                ->setCategory($fruits);
        $manager->persist($product);

        $product = new Product();
        $product->setLibelle("Pêche")
                ->setTexte("Elle va te la donner")
                ->setVisuel("images/peche.jpg")
                ->setPrix(2.84)
                ->setCategory($fruits);
        $manager->persist($product);

        $product = new Product();
        $product->setLibelle("Carotte")
                ->setTexte("C'est bon pour ta vue")
                ->setVisuel("images/carottes.jpg")
                ->setPrix(2.90)
                ->setCategory($legumes);
        $manager->persist($product);

        $product = new Product();
        $product->setLibelle("Tomate")
                ->setTexte("Fruit ou Légume ? Légume")
                ->setVisuel("images/tomates.jpg")
                ->setPrix(1.70)
                ->setCategory($legumes);
        $manager->persist($product);

        $product = new Product();
        $product->setLibelle("Chou Romanesco")
                ->setTexte("Mange des fractales")
                ->setVisuel("images/romanesco.jpg")
                ->setPrix(1.81)
                ->setCategory($legumes);
        $manager->persist($product);

        $product = new Product();
        $product->setLibelle("Nutella")
                ->setTexte("C'est bon, sauf pour ta santé")
                ->setVisuel("images/nutella.jpg")
                ->setPrix(4.50)
                ->setCategory($junkFood);
        $manager->persist($product);

        $product = new Product();
        $product->setLibelle("Pizza")
                ->setTexte("Y'a pas pire que za")
                ->setVisuel("images/pizza.jpg")
                ->setPrix(8.25)
                ->setCategory($junkFood);
        $manager->persist($product);

        $product = new Product();
        $product->setLibelle("Oreo")
                ->setTexte("Seulement si tu es un smartphone")
                ->setVisuel("images/oreo.jpg")
                ->setPrix(2.50)
                ->setCategory($junkFood);
        $manager->persist($product);

        $manager->flush();
    }
}
