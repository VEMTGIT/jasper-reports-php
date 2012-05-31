<?php
include __DIR__ . '/../bootstrap.php';

use Vemt\Jasper\Transport\SoapTransport;
use Vemt\Jasper\Request\Repository\RunReport;

// setup the soap transport
$cli = new SoapTransport($repositoryUrl, $user, $password);

// executing the get resources request
$request = new RunReport($cli);
$request->setUri('/report_unit_uri');

//setting the report type to html
$request->addExtraArgument('RUN_OUTPUT_FORMAT', 'HTML');

//adding parameters to the report
$request->addParameter('parameter 1', 'value 1');


$resource = $request->execute();



// display data
if ($resource->hasAttachments()) {
    foreach ($resource->getAttachments() as $name => $attachment) {
        // the report itself has the key 'cid:report'
        // images are also attached
        echo "\t $name => $attachment \n";
    }
} else {
    echo "no report returned\n";
}

