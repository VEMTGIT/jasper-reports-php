<?php

namespace francodacosta\Jasper\Request\Administration;
use francodacosta\Jasper\Exception\JasperException;

use francodacosta\Jasper\Resource\Role\Role;
use francodacosta\Jasper\Resource\Role\RoleSearchCriteria;
use francodacosta\Jasper\Request\AbstractRequest;

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
