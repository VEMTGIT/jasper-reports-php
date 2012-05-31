<?php
include __DIR__ . '/../bootstrap.php';

use Vemt\Jasper\Transport\SoapTransport;
use Vemt\Jasper\Request\Repository\ListResources;

// setup the soap transport
$cli = new SoapTransport($repositoryUrl, $user, $password);

// executing the list resources request
$request = new ListResources($cli);
$request->setUri('/');
$resources = $request->execute();


echo "Listing resources Resources at " . $request->getUri();
foreach ($resources as $resource) {
    echo $resource . "\n";
}