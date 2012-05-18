<?php
namespace francodacosta\Jasper\Transport;

use francodacosta\Jasper\Interfaces\TransportInterface;
use francodacosta\Jasper\Exception\JasperException;

/**
 * Soap Transport class.
 * Makes calls to jasper reports via Soap
 *
 * @author Nuno Costa <nuno@francodacosta.com>
 *
 */
class SoapTransport implements TransportInterface
{

    private $user;
    private $password;
    private $url;
    private $soap;

    /**
     * Constructs the class.
     *
     * @param string $url      the server soap request url
     * @param string $user     the username
     * @param string $password the password
     */
    public function __construct($url, $user, $password)
    {
        $this->setUrl($url);
        $this->setPassword($password);
        $this->setUser($user);
    }

    /**
     * (non-PHPdoc)
     * @see francodacosta\Jasper\Transport.TransportInterface::call()
     */
    public function call($name, $parameters)
    {
        $cli = $this->getSoap();

        $response =  $cli->call($name, $parameters);
// var_dump($response); die();
        // bail out on soap errors
        if (is_soap_fault($response) || ($response instanceof \Soap_Fault)) {
            $errorMessage = $response->getFault()->faultstring;

            error_log("[Jasper-php] SOAP Error : " . $errorMessage . "\n\t call: " . $name. " data: " . var_export($parameters, true));

            throw new JasperException($errorMessage);
        }

        if (is_string($response)) {
            $this->checkErrorCode($response);
        }


        return $response;
    }

    /**
     * checks the response string to see if we have a server error.
     *
     * @param string $response
     * @throws JasperException
     */
    private function checkErrorCode($response)
    {
        $xml = simplexml_load_string($response);

        // bail out on jasper errors

        if ($this->responseHasErrors($xml)) {
            $errorMessage = "Server returned error code " . $this->getErrorMessage($xml);
            error_log("[Jasper-php] SOAP Error : " . $errorMessage . "\n\t call: " . $name. " data: " . var_export($parameters, true));

            throw new JasperException($errorMessage);
        }
    }

    /**
     * returns true if server returns an error message.
     *
     * @param \SimpleXMLElement $xml
     *
     * @return boolean
     */
    private function responseHasErrors(\SimpleXMLElement $xml)
    {
        $code =  $xml->xpath('//returnCode');
        if (is_array($code)) {
            $code = $code[0];
        }
        $code = intval($code);

        return $code !== 0;
    }
    /**
     * gets jasper error from the response.
     *
     * @param SimpleXMLElement $xml
     *
     * @return string
     */
    private function getErrorMessage(\SimpleXMLElement $xml)
    {

        $code =  $xml->xpath('//returnCode');
        if (is_array($code)) {
            $code = $code[0];
        }
        $code = intval($code);

        $msg =  $xml->xpath('//returnMessage');
        if (is_array($msg)) {
            $msg = $msg[0];
        }
        $msg = (string) $msg;

        return "Code: $code - $msg";
    }
    /**
     * (non-PHPdoc)
     * @see francodacosta\Jasper\Transport.TransportInterface::getUser()
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * (non-PHPdoc)
     * @see francodacosta\Jasper\Transport.TransportInterface::setUser()
     */
    public function setUser($user)
    {
        $this->user = $user;
    }

    /**
     * (non-PHPdoc)
     * @see francodacosta\Jasper\Transport.TransportInterface::getPassword()
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * (non-PHPdoc)
     * @see francodacosta\Jasper\Transport.TransportInterface::setPassword()
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * (non-PHPdoc)
     * @see francodacosta\Jasper\Transport.TransportInterface::getUrl()
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * (non-PHPdoc)
     * @see francodacosta\Jasper\Transport.TransportInterface::setUrl()
     */
    public function setUrl($url)
    {
        $this->url = $url;
    }

    /**
     * gets the current instance of the Pear::Soap.
     *
     * @return Soap_Client
     */
    protected function getSoap()
    {
        if (null === $this->soap) {
            $this->setSoap($this->createSoapClient());
        }

        return $this->soap;
    }

    /**
     * sets the instance of the Pear::Soap client.
     *
     * @param unknown_type $soap
     */
    private function setSoap( $soap)
    {
        $this->soap = $soap;
    }

    /**
     * Creates an instance of Pear::Soap client.
     *
     * @return \Pear_Soap
     */
    protected function createSoapClient()
    {
        include_once('SOAP/Client.php');

        $url  = $this->getUrl();
        $user = $this->getUser();
        $pass = $this->getPassword();

        $opts = array(
                'location' => $url,
                'uri' => 'urn:',
                'user' => $user,
                'pass' => $pass,
                'trace' => 1,
                'exception' => 1,
                'soap_version' => SOAP_1_1,
                'style' => SOAP_RPC,
                'use' => SOAP_LITERAL,
                'timeout' => 120,
        );

        return new \Soap_Client($url . '?wsdl', false, false, $opts);
    }

    /**
     * (non-PHPdoc)
     * @see francodacosta\Jasper\Interfaces.TransportInterface::getRawResponse()
     */
    public function getRawResponse()
    {
        return $this->getSoap()->_soap_transport;
    }

}
