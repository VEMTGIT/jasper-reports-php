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
namespace Vemt\Jasper\Resource\User;

use Vemt\Jasper\Resource\Role\Role;

/**
 * Represents a Jasper user search criteria
 *
 * @author Nuno Costa <nuno@francodacosta.com>
 *
 */
class UserSearchCriteria
{
    public $name = '';
    public $tenantId = null;
    public $includeSubOrgs = true;
    public $requiredRoles = null;
    public $maxRecords = 0;

    /**
     * user name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * user name.
     *
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * Tennant id.
     *
     * @return integer|null
     */
    public function getTenantId()
    {
        return $this->tenantId;
    }

    /**
     * tennat id.
     *
     * @param integer|null $tenantId
     */
    public function setTenantId($tenantId)
    {
        $this->tenantId = $tenantId;
    }

    /**
     * include sub organizations.
     *
     * @return boolean
     */
    public function getIncludeSubOrgs()
    {
        return $this->includeSubOrgs;
    }

    /**
     * include sub organizations.
     *
     * @param boolean $includeSubOrgs
     */
    public function setIncludeSubOrgs($includeSubOrgs)
    {
        $this->includeSubOrgs = $includeSubOrgs;
    }

    /**
     * Roles the user must have.
     *
     * @return Role[]|null
     */
    public function getRequiredRoles()
    {
        return $this->requiredRoles;
    }

    /**
     * Roles the user must have
     * @param Role $requiredRoles
     */
    public function addRequiredRole(Role $requiredRoles)
    {
        null === $this->requiredRoles ? $this->requiredRoles = array(): false;

        $this->requiredRoles[] = $requiredRoles;
    }

    /**
     * maximum number of records to return.
     *
     * @return number
     */
    public function getMaxRecords()
    {
        return $this->maxRecords;
    }

    /**
     * maximum number of records to return.
     *
     * @param integer $maxRecords
     */
    public function setMaxRecords($maxRecords)
    {
        $this->maxRecords = $maxRecords;
    }

}
