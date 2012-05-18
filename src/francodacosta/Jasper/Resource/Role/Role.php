<?php
namespace francodacosta\Jasper\Resource\Role;

use francodacosta\Jasper\Resource\User\User;
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
