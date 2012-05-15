<?php
namespace francodacosta\Jasper\Request;
use francodacosta\Jasper\Interfaces\RequestInterface;
use francodacosta\Jasper\Interfaces\TransportInterface;

/**
 * Helper functions for request objects.
 *
 * @author Nuno Costa <nuno@francodacosta.com>
 *
 */
Abstract class AbstractRequest implements RequestInterface
{
    private $cli;

    /**
     * (non-PHPdoc)
     * @see francodacosta\Jasper\Interfaces.RequestInterface::__construct()
     */
    public function __construct(TransportInterface $transport)
    {
        $this->setCli($transport);
    }

    /**
     * (non-PHPdoc)
     * @see francodacosta\Jasper\Interfaces.RequestInterface::execute()
     */
    abstract function execute();

    /**
     * returns the transport client in use.
     *
     * @return TransportInterface
     */
    protected function getCli()
    {
        return $this->cli;
    }

    /**
     * Sets the transport client in use
     * @param TransportInterface $cli
     */
    protected function setCli(TransportInterface $cli)
    {
        $this->cli = $cli;
    }

}
