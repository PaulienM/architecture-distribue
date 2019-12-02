<?php


namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class BoutiqueController extends AbstractController
{
    public function index()
    {
        return $this->render('boutique/index.html.twig');
    }
}