<?php


namespace App\Service;


use Symfony\Component\HttpFoundation\Session\SessionInterface;

class DeviseService
{
    /**
     * @var SessionInterface
     */
    private $session;

    public function __construct(SessionInterface $session)
    {
        $this->session = $session;
    }

    public function getPriceIn(
        string $devise
    ) {
        $conversions = json_decode(file_get_contents(
            'https://api.exchangeratesapi.io/latest'
        ), true);
        $this->session->set('conversion', $conversions);
        return $conversions;
    }
}