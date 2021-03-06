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
namespace Vemt\Jasper\Request\Administration;
use Vemt\Jasper\Exception\JasperException;

use Vemt\Jasper\Resource\Role\Role;
use Vemt\Jasper\Resource\Role\RoleSearchCriteria;
use Vemt\Jasper\Request\AbstractRequest;

/**
 * Gets a list of Roles from the server.
 *
 * @author Nuno Costa <nuno@francodacosta.com>
 *
 */
class FindRoles extends AbstractRequest
{

    const METHOD = 'findRoles';
    const PARAM = 'criteria';

    private $searchCriteria = null;

    /**
     * executes the request.
     *
     * @return Role[]
     */
    public function execute()
    {
        $client = $this->getCli();

        $resources = $client->call(self::METHOD, array(self::PARAM => $this->getSearchCriteria()));

        if (false === is_array($resources)) {
            throw new JasperException('Unknown response format, expecting array got ' . gettype($reources));
        }

        $ret = array();
        foreach ($resources as $resource) {
            $ret[] = Role::fromObject($resource);
        }

        return $ret;
    }

    /**
     * Gets the criteria used to search.
     *
     * @return UserSearchCriteria
     */
    public function getSearchCriteria()
    {
        if (null === $this->searchCriteria) {
            $this->searchCriteria = new RoleSearchCriteria();
        }

        return $this->searchCriteria;
    }

    /**
     * Sets the criteria used to search.
     *
     * @param UserSearchCriteria $searchCriteria
     */
    public function setSearchCriteria(RoleSearchCriteria $searchCriteria)
    {
        $this->searchCriteria = $searchCriteria;
    }

}
