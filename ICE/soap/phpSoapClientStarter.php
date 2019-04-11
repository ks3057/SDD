<?php
//include the XML pretty print function
require "xmlpp.php";

try {

//requires php soap module - you can check for that using phpinfo()

    //   // not using WSDL
    //   $options = array(
//     "location" => "http://serenity.ist.rit.edu/~ks3057/756/ICE/soap/phpSoapServerNoWsdl.php",
//     "uri" => "http://serenity.ist.rit.edu/~ks3057",
//     "trace" => 1
    //   );
//
    // $client = new SoapClient(null, $options); //first param is WSDL

    //using the WSDL

    $options = array(
    "trace" => 1
  );

    $wsdl = "http://serenity.ist.rit.edu/~ks3057/756/ICE/soap/phpSoapServerWsdl.php?wsdl";
    $client = new SoapClient($wsdl, $options);
    $response = $client->helloWorld(); ?>

<h1>Hello World</h1>
<?= var_dump($response); ?>
<p>
   Response: <?= $response; ?>
</p>

<h3>Last Request</h3>
<pre>
  <?= xmlpp($client->__getLastRequest(), true); ?>
</pre>
<h3>Last Response</h3>
<pre>
  <?= xmlpp($client->__getLastResponse(), true); ?>
</pre>

<hr />

<?php
$response = $client->calcRectangle(10, 20.4); ?>
<h1>Calc Rectangle</h1>
<?= var_dump($response); ?>
<p>
   Response: <?= $response; ?>
</p>

<h3>Last Request</h3>
<pre>
  <?= xmlpp($client->__getLastRequest(), true); ?>
</pre>
<h3>Last Response</h3>
<pre>
  <?= xmlpp($client->__getLastResponse(), true); ?>
</pre>

<hr />

<?php
$response = $client->calcCircle(10); ?>
<h1>Calc Circle</h1>
<?= var_dump($response); ?>
<p>
   Response: <?= $response; ?>
</p>

<h3>Last Request</h3>
<pre>
  <?= xmlpp($client->__getLastRequest(), true); ?>
</pre>
<h3>Last Response</h3>
<pre>
  <?= xmlpp($client->__getLastResponse(), true); ?>
</pre>

<hr />


<?php
$response = $client->countTo(15); ?>
<h1>Count To</h1>
<?= var_dump($response); ?>
<p>
   Response:
   <?php
   if ($response) {
       foreach ($response as $value) {
           echo $value."<br />";
       }
   } ?>
</p>

<h3>Last Request</h3>
<pre>
  <?= xmlpp($client->__getLastRequest(), true); ?>
</pre>
<h3>Last Response</h3>
<pre>
  <?= xmlpp($client->__getLastResponse(), true); ?>
</pre>

<hr />

<?php
} //end try
catch (SoapFault $e) {
    echo "Soap Fault:";
    var_dump($e);
}
?>
