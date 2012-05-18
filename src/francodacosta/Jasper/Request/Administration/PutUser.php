<?php

namespace francodacosta\Jasper\Request\Administration;
use francodacosta\Jasper\Exception\JasperException;

use francodacosta\Jasper\Resource\User\User;
use francodacosta\Jasper\Resource\User\UserSearchCriteria;
use francodacosta\Jasper\Request\AbstractRequest;

/**
 * Adds an user to jasper.
 *
 * @author Nuno Costa <nuno@francodacosta.com>
 *
 */
class PutUser extends AbstractRequest
{

    const METHOD = 'putUser';

    private $user = null;

    /**
     * executes the request.
     *
     * @return francodacosta\Jasper\Resource\Resource
     */
    public function execute()
    {
        $client = $this->getCli();

        $user = $this->getUser();
        if (null === $user) {
            throw new JasperException('No user to save');
        }

        $resources = $client->call(self::METHOD, array('user' => $user));

        if (false === is_object($resources)) {
            throw new JasperException('Unknown response format, expecting object got ' . gettype($resources));
        }


        var_dump($resources); die();

        return User::fromObject($resources);
    }

    /**
     * Gets the user to save.
     *
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Sets user to save.
     *
     * @param User $user
     */
    public function setUser(User $user)
    {
        $this->user = $user;
    }

}
