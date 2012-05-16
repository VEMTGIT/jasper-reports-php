<?php
namespace francodacosta\Jasper\Request\Repository;

use francodacosta\Jasper\Resource\Resource;

/**
 * Runs a report on the server.
 *
 * @author Nuno Costa <nuno@francodacosta.com>
 *
 */
class RunReport extends BaseRepositoryRequest
{

    /**
     * gets the report result and attachments from the server.
     *
     * @return francodacosta\Jasper\Resource\Resource
     */
    public function execute()
    {
        $client = $this->getCli();
        $this->addExtraArgument('USE_DIME_ATTACHMENTS', 1);

        $xml = $this->generateXmlRequest();

        $resources = $client->call("runReport", array('request' => $xml));

        $resources = simplexml_load_string($resources);
        $ret =  $this->toResourceObject($resources);

        $attachments = $client->getRawResponse()->attachments;
        if (is_array($attachments)) {
            $ret->setAttachments($attachments);
        }

        return $ret;
    }

}
