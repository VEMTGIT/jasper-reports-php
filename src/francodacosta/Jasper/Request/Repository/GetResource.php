<?php

namespace francodacosta\Jasper\Request\Repository;


use francodacosta\Jasper\Resource\Resource;

/**
 * Gets a resource defenition from the server.
 *
 * @author Nuno Costa <nuno@francodacosta.com>
 *
 */
class GetResource extends BaseRepositoryRequest
{


    /**
     * Gets the resource defenition and attachments from the server.
     *
     * @return francodacosta\Jasper\Resource\Resource
     */
    public function execute()
    {
        $client = $this->getCli();
        $xml = $this->generateXmlRequest();

        $resources = $client->call("get", array('request' => $xml));


        $resources = simplexml_load_string($resources);

        $ret =  $this->toResourceObject($resources);

        return $ret;
    }

}
