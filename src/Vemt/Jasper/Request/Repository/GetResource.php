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
     * @return Vemt\Jasper\Resource\Resource
     */
    public function execute()
    {
        $client = $this->getCli();
        $xml = $this->generateXmlRequest();

        $resources = $client->call("get", array('requestXmlString' => $xml));


        $resources = simplexml_load_string($resources);

        $ret =  $this->toResourceObject($resources);

        return $ret;
    }

}
