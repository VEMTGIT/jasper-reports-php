<?php
include __DIR__ . '/../bootstrap.php';

use Vemt\Jasper\Transport\SoapTransport;
use Vemt\Jasper\Request\Repository\GetResource;

// setup the soap transport
$cli = new SoapTransport($repositoryUrl, $user, $password);

// executing the get resources request
$request = new GetResource($cli);
$request->setUri('/');
$resource = $request->execute();


// display data
echo $resource . "\n";

echo "Attachments:\n";
if ($resource->hasAttachments()) {
    foreach ($resource->getAttachments() as $attachment) {
        // an attachment is another resource object
        echo "\t $attachment \n";
    }
} else {
    echo "none\n";
}

