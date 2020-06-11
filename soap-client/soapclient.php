<?php

namespace SoapClient;

use SoapClient\Commande;
use SoapClient\User;

require_once("Commande.php");
require_once("User.php");

ini_set("soap.wsdl_cache_enabled", "0");
$options = [
    'trace'        => 1,
    'encoding'     => 'UTF-8',
    'soap_version' => SOAP_1_2,
    'classmap'     => [
        'CommandeSoap' => "\SoapClient\Commande",
        'UserSoap'     => '\SoapClient\User'
    ],
];

try {
    $soapClient = new \SoapClient('http://127.0.0.1:8000/soap?wsdl', $options);
} catch (SoapFault $e) {
    var_dump($e);
}

try {
    $functions = $soapClient->__getFunctions();
    var_dump($functions);
    $result = $soapClient->__soapcall("sayHello", ['michel']);
    echo '<p>'.$result.'</p>';
    $result = $soapClient->__soapcall("sumHello", [2,5]);
    echo '<p>'.$result.'</p>';

    /** @var User $user */
    $user = $soapClient->__soapCall("getUserById", [6]);
    echo '<p> ID : '.$user->getId().'</p>';
    echo '<p> Nom : '.$user->getNom().'</p>';
    echo '<p> Prénom : '.$user->getPrenom().'</p>';

    /** @var Commande $commande */
    $commande = $soapClient->__soapcall("getFirstCommandByUserId", [4]);
    echo '<p> ID : '.$commande->getId().'</p>';
    echo '<p> Statut : '.$commande->getStatut().'</p>';
    echo '<p> Date de commande : '.$commande->getDateCommande().'</p>';

} catch (SoapFault $e) {
    var_dump($e->getMessage());
}