<?php
namespace francodacosta\Jasper\Resource\User;
use francodacosta\Jasper\Resource\Role\Role;
/**
 * Jasper User.
 *
 * @author Nuno Costa <nuno@francodacosta.com>
 *
 */
class User
{
    private $username;
    private $fullName;
    private $password;
    private $emailAddress;
    private $externallyDefined;
    private $enabled;
    private $previousPasswordChangeTime;
    private $tenantId;
    private $roles;

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
