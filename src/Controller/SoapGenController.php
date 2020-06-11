<?php


namespace App\Controller;

use Laminas\Soap\Wsdl;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Laminas\Soap\AutoDiscover;

class SoapGenController
{
    /**
     * @Route("/soapgen", name="soapgen")
     */
    public function soapGenAction()
    {
        //$wsdl = new Wsdl("/soap.wdsl", 'http://localhost:8000/soap');
        //$wsdl->addComplexType('\App\Soap\UserSoap');
        $autodiscover = new AutoDiscover();

        $autodiscover->setClass('App\Soap\SoapClass')
            ->setUri('http://localhost:8000/soap')
            ->setServiceName('SoapGenService');
        header('Content-Type: application/wsdl+xml');
        $wsdl=$autodiscover->generate();
        $wsdl->dump("../soap.wsdl");
        return new Response($wsdl->toXml());
    }
}