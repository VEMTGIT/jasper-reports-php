<?php
namespace francodacosta\Jasper\Resource\User;

use francodacosta\Jasper\Resource\Role\Role;

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
