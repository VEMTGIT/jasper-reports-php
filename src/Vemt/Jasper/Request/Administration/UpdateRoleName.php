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
 * @author     Herberto Graca <herberto.graca@gmail.com>
 * @copyright  2012 VEMT – Value Exchange and Marketing Technology <http://www.vemt.com>
 * @license    http://www.opensource.org/licenses/mit-license.php MIT license
 */
namespace Vemt\Jasper\Request\Administration;
use Vemt\Jasper\Exception\JasperException;

use Vemt\Jasper\Resource\Role\Role;
use Vemt\Jasper\Resource\Role\RoleSearchCriteria;
use Vemt\Jasper\Request\AbstractRequest;

/**
 * Updates a role name in jasper.
 *
 * @author Herberto Graca <herberto.graca@gmail.com>
 *
 */
class UpdateRoleName extends AbstractRequest
{

    const METHOD = 'updateRoleName';
    
    private $role = null;
    private $newName = null;

    /**
     * executes the request.
     *
     * @return Vemt\Jasper\Resource\Resource
     */
    public function execute()
    {
        $client = $this->getCli();
        
        $role = $this->getRole();
        if (null === $role) {
        	throw new JasperException('No role to update');
        }
        
        $newName = $this->getNewName();
        if (null === $newName) {
            throw new JasperException('No new name set');
        }

        $resources = $client->call(self::METHOD, array('oldRole' => $role, 'newName' => $newName));

        if (false === is_object($resources)) {
            throw new JasperException('Unknown response format, expecting object got ' . gettype($resources));
        }

        return Role::fromObject($resources);
    }

    /**
     * Gets the role to update.
     *
     * @return Role
     */
    public function getRole()
    {
        return $this->role;
    }

    /**
     * Sets role to update.
     *
     * @param Role $role
     */
    public function setRole(Role $role)
    {
        $this->role = $role;
    }

    /**
     * Gets the role new name.
     *
     * @return Role
     */
    public function getNewName()
    {
        return $this->newName;
    }

    /**
     * Sets role new name.
     *
     * @param String $newName
     */
    public function setNewName($newName)
    {
        $this->newName = $newName;
    }

}
