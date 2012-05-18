<?php
namespace francodacosta\Jasper\Resource\Role;

/**
 * Search criteria for security roles.
 *
 * @author Nuno Costa <nuno@francodacosta.com>
 *
 */
class RoleSearchCriteria
{

    public $roleName = null;
    public $tenantId = null;
    public $includeSubOrgs = true;
    public $maxRecords = 0;

    /**
     * @return string
     */
    public function getRoleName()
    {
        return $this->roleName;
    }

    /**
     * @param string $roleName
     */
    public function setRoleName($roleName)
    {
        $this->roleName = $roleName;
    }

    /**
     * @return string
     */
    public function getTenantId()
    {
        return $this->tenantId;
    }

    /**
     * @param string $tenantId
     */
    public function setTenantId($tenantId)
    {
        $this->tenantId = $tenantId;
    }

    /**
     * @return boolean
     */
    public function getIncludeSubOrgs()
    {
        return $this->includeSubOrgs;
    }

    /**
     * @param boolean $includeSubOrgs
     */
    public function setIncludeSubOrgs($includeSubOrgs)
    {
        $this->includeSubOrgs = $includeSubOrgs;
    }

    /**
     * @return integer
     */
    public function getMaxRecords()
    {
        return $this->maxRecords;
    }

    /**
     * @param integer $maxRecords
     */
    public function setMaxRecords($maxRecords)
    {
        $this->maxRecords = $maxRecords;
    }

}
