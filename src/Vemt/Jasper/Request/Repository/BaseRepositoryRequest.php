<?php
/**
 * Jasper Reports PHP integration
 *
 * PHP version 5
 *
 * LICENSE:
 * Permission is hereby granted, free of charge, to any person
 * obtaining a copy of this software and associated documentation files
 * (the "Software"), to deal in the Software without restriction, including
 * without limitation the rights to use, copy, modify, merge, publish,
 * distribute, sublicense, and/or sell copies of the Software, and to permit
 * persons to whom the Software is furnished to do so, subject to the following
 * conditions:
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE,
 * ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER
 * DEALINGS IN THE SOFTWARE.
 *
 * == USE IT AT YOUR OWN RISK ==
 *
 * @package    Jasper-Reports
 * @author     Nuno Costa <nuno@francodacosta.com>
 * @copyright  2012 VEMT – Value Exchange and Marketing Technology <http://www.vemt.com>
 * @license    http://www.opensource.org/licenses/mit-license.php MIT license
 */
namespace Vemt\Jasper\Request\Repository;

use Vemt\Jasper\Resource\Resource;
use Vemt\Jasper\Interfaces\RequestInterface;
use Vemt\Jasper\Request\AbstractRequest;


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
    protected function generateXmlRequest($operationName = 'list', $type = 'folder', $name="")
    {
        $uri        = $this->getUri();
        $arguments  = $this->getExtraArguments();
        $parameters = $this->getParameters();

        $xml = sprintf('<request operationName="%s">', $operationName);

        foreach ($arguments as $key => $value) {
            $xml .= sprintf('<argument name="%s"><![CDATA[%s]]></argument>', $key, $value);
        }

        $xml .= sprintf(
            '<resourceDescriptor
                name="%s"
                wsType="%s"
                uriString="%s"
                isNew="false"
                >
            <label></label>', $name, $type, $uri);

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
