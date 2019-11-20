<?php


namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class DefaultController extends AbstractController
{
    public function index($userName)
    {
        return $this->render('default/home.html.twig', [
            'userName' => $userName
        ]);
    }
}