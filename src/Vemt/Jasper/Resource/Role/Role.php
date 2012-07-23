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
namespace Vemt\Jasper\Resource\Role;
use Vemt\Jasper\Resource\User\User;
/**
 * Jasper security Role.
 *
 * @author Nuno Costa <nuno@francodacosta.com>
 *
 */
class Role
{

    public $roleName;
    public $externallyDefined;
    public $tenantId;
    public $users;

    
    function __construct($roleName=null, $tenantId=null)
    {
        $this->setRoleName($roleName);
        $this->setTenantId($tenantId);
    }
    
    
    
    /**
     * @return the unknown_type
     */

    public function getRoleName()
    {
        return $this->roleName;
    }

    /**
     * @param unknown_type $roleName
     */

    public function setRoleName($roleName)
    {
        $this->roleName = $roleName;
    }

    /**
     * @return the unknown_type
     */

    public function getExternallyDefined()
    {
        return $this->externallyDefined;
    }

    /**
     * @param unknown_type $externallyDefined
     */

    public function setExternallyDefined($externallyDefined)
    {
        $this->externallyDefined = $externallyDefined;
    }

    /**
     * @return the unknown_type
     */

    public function getTenantId()
    {
        return $this->tenantId;
    }

    /**
     * @param unknown_type $tenantId
     */

    public function setTenantId($tenantId)
    {
        $this->tenantId = $tenantId;
    }

    /**
     * @return the unknown_type
     */

    public function getUsers()
    {
        return $this->users;
    }

    /**
     * @param unknown_type $users
     */

    public function addUser($users)
    {
        null === $this->users ? $this->users = array() : false;

        $this->users = $users;
    }

    /**
     * populates this object, from an object.
     * Used mainly to convert soap responses into User object
     *
     * @param object $object
     *
     * @return Role
     */
    public static function fromObject($object)
    {
         $me = new Role;

        $properties = get_object_vars($object);

        foreach ($properties as $name => $defaultValue) {
            switch ($name) {

            case 'users':
                foreach ($object->$name as $userObj) {
                    $user = new User();
                    $me->addUser(Role::fromObject($userObj));
                }

                break;

            default:
                $setter = 'set' . ucfirst($name);
                if (method_exists($me, $setter)) {
                    $me->$setter($object->$name);
                }
                break;
            }
        }

        return $me;
    }

}
