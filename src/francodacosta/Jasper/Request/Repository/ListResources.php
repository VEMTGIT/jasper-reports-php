<?php
namespace francodacosta\Jasper\Request\Repository;

use francodacosta\Jasper\Resource\Resource;
use francodacosta\Jasper\Interfaces\RequestInterface;
use francodacosta\Jasper\Request\AbstractRequest;


/**
 * Lists resources on the server.
 * You can specify the server location (obviously)
 * You can optionaly filter the results by resource type
 *
 * @author Nuno Costa <nuno@francodacosta.com>
 *
 */
class ListResources extends BaseRepositoryRequest
{

    private $filters = array();

    /**
     * Executes the request.
     *
     * @return francodacosta\Jasper\Repository\Resource[]
     */
    public function execute()
    {
        $client = $this->getCli();

        $filters = $this->getFilters();

        $xml = $this->generateXmlRequest();

        $resources = $client->call("list", array('request' => $xml));
        $ret =  $this->toResourceObjectArray($resources);

        if (count($this->getFilters()) > 0) {
            $resources = $this->filterResources($resources, $filters);
        }

        return $ret;
    }


    /**
     * Transforms the response object into a Resource class
     *
     * @param string xml response
     *
     * @return Resource[]
     */
    private function toResourceObjectArray($response)
    {
        $items = simplexml_load_string($response);
        $ret = array();
        foreach ($items as $item) {
            $ret[] = $this->toResourceObject($item);
        }

        return $ret;
    }

    /**
     * filters a Jasper List response, to get.
     *
     * @param xml      $response the server response
     * @param string[] $type     the types to filter for
     *
     * @return SimpleXml[]
     */
    private function filterResources($xml, array $type)
    {

        $resources = $xml->resourceDescriptor;

        $ret = array();
        foreach ($xml->resourceDescriptor as $resource) {
            $attributes = $resource->attributes();

            if (property_exists($attributes, 'wsType')) {
                if (in_array($attributes->wsType, $type)) {
                    $ret[] = $resource;
                }
            }
        }

        return $ret;
    }


    /**
     * return the filters we are using.
     *
     * @return string[]
     */
    public function getFilters()
    {
        return $this->filters;
    }

    /**
     * Sets the resource type(s) to filter for.
     *
     * @param string[] $filters
     */
    public function setFilters($filters)
    {
        $this->filters = $filters;
    }

}
