<?php

namespace francodacosta\Jasper\Request\Repository;


use francodacosta\Jasper\Resource\Resource;
use francodacosta\Jasper\Resource\ReportUnitResource;
use francodacosta\Jasper\Exception\JasperException;

class GetResource extends BaseRepositoryRequest
{
    private $cli;
    private $uri;
    private $options = array();


    private function toResourceObject($response)
    {

        $xml = simplexml_load_string($response);
        $resource = $xml->resourceDescriptor;

        $ret = null;
        switch ($resource->attributes()->wsType) {
            case 'reportUnit':
                $ret = new ReportUnitResource();
                break;
            default:
                $ret = new Resource();
                break;
        }

        $ret->fromJasperListResponse($resource);

        return $ret;
    }

    public function go()
    {

        $client = $this->cli;
        $uri = $this->getUri();

        $xml = '<request operationName="get">';
        foreach ($this->getOptions() as $key => $value) {
            $xml .= sprintf('<argument name="%s">%s</argument>', $key, $value);
        }
        $xml .= sprintf('<resourceDescriptor name="%s" wsType="reportUnit" uriString="%s" isNew="false">', $uri, $uri);
        $xml .= '<label></label>';
        $xml .= '</resourceDescriptor>';
        $xml .= '</request>';

        $params = array("request" => $xml );

        $result = $client->call('get', $params, array('namespace' => "http://www.jaspersoft.com/client"));

        if (is_soap_fault($result)) {
            $errorMessage = $result->getFault()->faultstring;

            throw new JasperException($errorMessage);
        }


        $ret = $this->toResourceObject($result);

        return $ret;
    }


    public function addOption($name, $value)
    {
        $this->options[$name] = $value;
    }

    public function getOptions($name = null)
    {
        return is_null($name) ? $this->options : $this->options[$name];
    }

}
