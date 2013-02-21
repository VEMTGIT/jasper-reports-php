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
 * @author     Eric Zhou <eric@vemt.com>
 * @copyright  2013 VEMT – Value Exchange and Marketing Technology <http://www.vemt.com>
 * @license    http://www.opensource.org/licenses/mit-license.php MIT license
 */
namespace Vemt\Jasper\Request\Administration;
use Vemt\Jasper\Exception\JasperException;

use Vemt\Jasper\Request\AbstractRequest;
use Vemt\Jasper\Resource\Permission\Permission;

/**
 * Get permission for object from jasper.
 *
 * @author Eric Zhou <eric@vemt.com>
 *
 */
class GetPermission extends AbstractRequest
{

    const METHOD = 'getPermissionsForObject';
    const PARAM = 'targetURI';
    public $repository = null;
    /**
     * executes the request.
     *
     * @return Vemt\Jasper\Resource\Resource
     */
    public function execute()
    {
        $client = $this->getCli();
        $resources = $client->call(self::METHOD, array(self::PARAM => $this->getRepository()));

        if (false === is_array($resources)) {
            throw new JasperException('Unknown response format, expecting array got ' . gettype($resources));
        }

		foreach ($resources as $r) {
			$ret[] = Permission::fromObjet($r);

		}

        return $ret;
    }
	/**
	 * Set Repository
	 *
	 * @param String $repository
	 */
    public function setRepository($repository)
    {
    	$this->repository = $repository;
    }
    /**
     * Get Repository
     *
     * @return repository
     */
    public function getRepository()
    {
    	return $this->repository;
    }

}
