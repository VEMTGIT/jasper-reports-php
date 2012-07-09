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
 * Jasper User.
 *
 * @author Nuno Costa <nuno@francodacosta.com>
 *
 */
class User
{
    public $username = null;
    public $fullName = null;
    public $password = null;
    public $emailAddress = null;
    public $externallyDefined = null;
    public $enabled = null;
    public $previousPasswordChangeTime = null;
    public $tenantId = null;
    public $roles = null;

    /**
     * username.
     *
     * @return the string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * username.
     *
     * @param string $username
     */
    public function setUsername($username)
    {
        $this->username = $username;
    }

    /**
     * full name.
     *
     * @return string
     */
    public function getFullName()
    {
        return $this->fullName;
    }

    /**
     * full name.
     *
     * @param string $fullName
     */
    public function setFullName($fullName)
    {
        $this->fullName = $fullName;
    }

    /**
     * password.
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * password.
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * email.
     *
     * @return string
     */
    public function getEmailAddress()
    {
        return $this->emailAddress;
    }

    /**
     * email.
     *
     * @param string $emailAddress
     */
    public function setEmailAddress($emailAddress)
    {
        $this->emailAddress = $emailAddress;
    }

    /**
     * externally defined.
     * @return boolean
     */
    public function getExternallyDefined()
    {
        return $this->externallyDefined;
    }

    /**
     * externally defines.
     * @param boolean $externallyDefined
     */
    public function setExternallyDefined($externallyDefined)
    {
        $this->externallyDefined = $externallyDefined;
    }

    /**
     * enabled.
     *
     * @return boolean
     */
    public function getEnabled()
    {
        return $this->enabled;
    }

    /**
     * enabled.
     *
     * @param boolean $enabled
     */
    public function setEnabled($enabled)
    {
        $this->enabled = $enabled;
    }

    /**
     * previous password change time.
     *
     * @return timestamp
     */
    public function getPreviousPasswordChangeTime()
    {
        return $this->previousPasswordChangeTime;
    }

    /**
     * pervious password change time.
     *
     * @param timestamp $previousPasswordChangeTime
     *
     */
    public function setPreviousPasswordChangeTime($previousPasswordChangeTime)
    {
        $this->previousPasswordChangeTime = $previousPasswordChangeTime;
    }

    /**
     * tennant id.
     *
     * @return string
     */
    public function getTenantId()
    {
        return $this->tenantId;
    }

    /**
     * tennant id.
     *
     * @param string $tenantId
     */
    public function setTenantId($tenantId)
    {
        $this->tenantId = $tenantId;
    }

    /**
     * roles.
     *
     * @return Role[]
     */
    public function getRoles()
    {
        return $this->roles;
    }

    /**
     * add a role.
     *
     * @param Role $role
     */
    public function addRole($role)
    {
        null === $this->roles ? $this->roles = array() : false;

        $this->roles[] = $role;
    }

    /**
     * populates this object, from an object.
     * Used mainly to convert soap responses into User object
     *
     * @param Object $object
     *
     * @return User
     */
    public static function fromObject($object)
    {
        $me = new User;

        $properties = get_object_vars($object);

        foreach ($properties as $name => $defaultValue) {
            switch ($name) {

            case 'roles':
                foreach ($object->$name as $roleObj) {
                    $role = new Role();
                    $me->addRole(Role::fromObject($roleObj));
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
