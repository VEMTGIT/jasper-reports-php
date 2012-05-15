#jasper-reports-php

jasper reports php library

Pure php library for jasper reports

##Requirements

* Pear::Soap _as it seems to be the only client able to understant multiparted soap responses_


#Usage
### Listing resources on the server:

    use francodacosta\Jasper\Transport\SoapTransport;
    use francodacosta\Jasper\Request\Repository\ListResources;
    
    // setup the soap transport
    $cli = new SoapTransport($repositoryUrl, $user, $password);
    
    // executing the list resources request
    $request = new ListResources($cli);
    $request->setUri('/');
    $resources = $request->execute();
    
    
    echo "Listing resources Resources at " . $request->getUri();
    foreach($resources as $resource) {
        echo $resource . "\n";
    }
