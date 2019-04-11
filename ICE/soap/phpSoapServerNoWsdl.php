<?php
//proxy for AreaService

require_once("AreaService.php");

$server = new SoapServer(null, array(
      "uri" => "http://serenity.ist.rit.edu/~ks3057/756/ICE/soap/phpSoapServerNoWsdl.php",
));

$server->setClass("AreaService");
$server->handle();
