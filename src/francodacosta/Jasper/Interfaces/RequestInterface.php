<?php
namespace francodacosta\Jasper\Interfaces;

/**
 * Represents the minimul methods to do a request to jasper.
 *
 * @author Nuno Costa <nuno@francodacosta.com>
 *
 */
Interface RequestInterface
{

    /**
     * Initializes needed dependencies
     * @param TransportInterface $transport
     */
    public function __construct(TransportInterface $transport);

    /**
     * executes the request;
     */
    public function execute();
}