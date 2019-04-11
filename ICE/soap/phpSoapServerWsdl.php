<?php
//creating and using phpSoapServerNoWsdl
//from github.com/jk/php-wsdl-creator

//on serenity, apache is in the "group" cluster so give it write access
//that is set permission on php-wsdl/cache to 770
//drwxrwx--- 2 ks3057 instructors    21 Mar  1 14:52 cache
require "php-wsdl/class.phpwsdl.php";

$soap = PhpWsdl::CreateInstance(
  null, //namespace - let php wsdl choose
  null, //endpoint uri
  "./php-wsdl/cache", //WSDL cache loacation which must be writable by APACHE
  array( //classes to expose to API (should have WSDL annotations!)
    "AreaService.php"
  ),
  null, //name of class that serves the web AreaService
  null, // API demo file
  null, // complex types demo file
  false, // dont automatically send wsdl
  false //dont start SOAP server right now
);

//disable caching for dev/testing

ini_set("soap.wsdl_cache_enabled", 0); //for PHP
ini_set("soap.wsdl_cache_ttl", 0);
PhpWsdl::$CacheTime=0; //for PhpWsdl

//WSDL requested by the client?
if ($soap->isWsdlRequested()) {
    //remove line breaks and tabs
    $soap->Optimize = false;
}

//start the soap server
$soap->RunServer();
