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
    private $uri = '/';
    private $extraArguments = array();
    private $parameters = array();

    /**
     * generates a basic xml representing a request.
     * for most common cases this is enough
     *
     * @param string $type the resource type
     * @param string $name the resource name
     *
     * @return string xml
     */
    protected function generateXmlRequest($type = 'folder', $name="")
    {
        $uri        = $this->getUri();
        $arguments  = $this->getExtraArguments();
        $parameters = $this->getParameters();

        $xml = '<request operationName="list">';

        foreach ($arguments as $key => $value) {
            $xml .= sprintf('<argument name="%s"><![CDATA[%s]]></argument>', $key, $value);
        }

        $xml .= sprintf(
            '<resourceDescriptor
                name="%s"
                wsType="folder"
                uriString="%s"
                isNew="false"
                >
            <label></label>', $name, $uri);

        foreach ($parameters as $key => $value) {
            $xml .= sprintf('<parameter name="%s"><![CDATA[%s]]></parameter>', $key, $value);
        }

        $xml .= '</resourceDescriptor></request>';

        return $xml;
    }


    /**
     * Transforms the response object into a Resource class
     *
     * @param SimpleXML  $item
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
     * this will overwrite existing arguments
     *
     * @param string[] $extraArguments
     */
    public function setExtraArguments($extraArguments)
    {
        $this->extraArguments = $extraArguments;
    }

    /**
     * Adds an extra argument to the request.
     *
     * @param string $name  then name
     * @param string $value the value
     *
     * @return none
     */
    public function addExtraArgument($name, $value)
    {
        $this->extraArguments[$name] = $value;
    }


    /**
     * Sets the request parameters.
     * this will overwrite existing parameters
     *
     * @param stirng[] $parameters
     *
     * @return none
     */
    public function setParameters(array $parameters)
    {
        $this->parameters = $parameters;
    }

    /**
     * Adds a parameter to the request.
     *
     * @param string $name  then name
     * @param string $value the value
     *
     * @return none
     */
    public function addParameter($name, $value)
    {
        $this->parameters[$name] = $value;
    }

    /**
     * return the parameters set
     *
     * @return string[]
     */
    public function getParameters()
    {
        return $this->parameters;
    }

}
