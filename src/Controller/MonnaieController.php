<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class MonnaieController extends AbstractController
{
    public function choisirMonnaie(
        string $devise,
        string $route,
        string $route_parameters,
        SessionInterface $session
    ) {
        parse_str(urldecode($route_parameters),$params);
        $session->set('currency', $devise);
        return $this->redirectToRoute($route, $params);
    }
}
