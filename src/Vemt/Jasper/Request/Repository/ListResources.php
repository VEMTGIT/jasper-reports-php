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
 * @author Nuno Costa <nuno@Vemt.com>
 *
 */
class ListResources extends BaseRepositoryRequest
{

    private $filters = array();

    /**
     * Executes the request.
     *
     * @return Vemt\Jasper\Repository\Resource[]
     */
    public function execute()
    {
        $client = $this->getCli();

        $filters = $this->getFilters();

        $xml = $this->generateXmlRequest();

        $resources = $client->call("list", array('requestXmlString' => $xml));
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
