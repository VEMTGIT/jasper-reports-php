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
Abstract class BaseRepositoryRequest extends AbstractRequest
{
    private $cli;
    private $url = '/';
    private $extraArguments = array();


    protected function generateXmlRequest($type = 'folder', $name="")
    {
        $uri = $this->getUri();
        $arguments = $this->getExtraArguments();

        $xml = '<request operationName="list">';

        foreach ($arguments as $key => $value) {
            $xml .= sprintf('<argument name="%s">%s</argument>', $key, $value);
        }

        $xml .= sprintf(
            '<resourceDescriptor
                name="%s"
                wsType="folder"
                uriString="%s"
                isNew="false"
                >
            <label></label>
            </resourceDescriptor>', $name, $uri);

        $xml .= '</request>';

        return $xml;
    }


    /**
     * Transforms the response object into a Resource class
     *
     * @param SimpleXML  xml
     *
     * @return Resource
     */
    protected function toResourceObject($item)
    {
        $obj = new Resource();
        $obj->fromJasperListResponse($item);

        return $obj;
    }


    /**
     * returns the server location where we are listing the resouces.
     *
     * @return string
     */
    public function getUri()
    {
        return $this->uri;
    }

    /**
     * sets the server location where we are listing the resouces.
     *
     * @param strin $location
     */
    public function setUri($location)
    {
        $this->uri = $location;
    }

    /**
     * gets any arguments we are passing to the server.
     *
     * @return string[]
     */
    public function getExtraArguments()
    {
        return $this->extraArguments;
    }

    /**
     * Sets arguments to pass to the server.
     *
     * @param string[] $extraArguments
     */
    public function setExtraArguments($extraArguments)
    {
        $this->extraArguments = $extraArguments;
    }

}
