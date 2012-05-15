<?php
namespace francodacosta\Jasper\Interfaces;

/**
 * Minimal functionality for a Transport client (HTTP, REST, SOAP, etc...).
 *
 * @author Nuno Costa <nuno@francodacosta.com>
 *
 */
Interface TransportInterface
{
    /**
     * does a call to jasper reports server
     *
     * @param string $name the call name
     * @param array $parameters parameters to pass
     */
    public function call($name, $parameters);

    /**
     * Sets the username.
     *
     * @param string $user
     */
    public function setUser($user);

    /**
     * gets the username.
     *
     * @return string
     */
    public function getUser();

    /**
     * Sets the password.
     *
     * @param unknown_type $password
     */
    public function setPassword($password);

    /**
     * Gets the password.
     *
     * @return string
     */
    public function getPassword();

    /**
     * Sets the call url.
     *
     * @param string $url
     */
    public function setUrl($url);

    /**
     * gets the call ur;
     *
     * @return string
     */
    public function getUrl();
}