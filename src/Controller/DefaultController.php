<?php


namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class DefaultController extends AbstractController
{
    public function index()
    {
        return $this->render('default/home.html.twig');
    }

    public function contact()
    {
        return $this->render('default/contact.html.twig');
    }
}