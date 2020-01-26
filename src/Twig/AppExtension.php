<?php

namespace App\Twig;

use App\Service\DeviseService;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class AppExtension extends AbstractExtension
{
    /**
     * @var DeviseService
     */
    private $deviseService;
    /**
     * @var SessionInterface
     */
    private $session;

    public function __construct(
        DeviseService $deviseService,
        SessionInterface $session
    ) {
        $this->deviseService = $deviseService;
        $this->session       = $session;
    }

    public function getFilters()
    {
        return [
            new TwigFilter('currency_convert', [$this, 'convertPrice']),
        ];
    }

    public function convertPrice($number)
    {
        if ( ! $this->session->get('currency')) {
            $this->session->set('currency', 'EUR');
        }
        $devise = $this->session->get('currency');
        $conversions = $this->session->get('conversion')
            ?: $this->deviseService->getPriceIn($devise);

        if ($devise === 'EUR') {
            return $number;
        } else {
            return $number * $conversions['rates'][$devise];
        }
    }
}