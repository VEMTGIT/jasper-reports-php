<?php
/**
 * Jasper Reports PHP integration
 *
 * PHP version 5
 *
 * LICENSE:
 * Permission is hereby granted, free of charge, to any person
 * obtaining a copy of this software and associated documentation files
 * (the "Software"), to deal in the Software without restriction, including
 * without limitation the rights to use, copy, modify, merge, publish,
 * distribute, sublicense, and/or sell copies of the Software, and to permit
 * persons to whom the Software is furnished to do so, subject to the following
 * conditions:
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE,
 * ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER
 * DEALINGS IN THE SOFTWARE.
 *
 * == USE IT AT YOUR OWN RISK ==
 *
 * @package    Jasper-Reports
 * @author     Nuno Costa <nuno@francodacosta.com>
 * @copyright  2012 VEMT – Value Exchange and Marketing Technology <http://www.vemt.com>
 * @license    http://www.opensource.org/licenses/mit-license.php MIT license
 */
namespace Vemt\Jasper\Transport;

use Vemt\Jasper\Interfaces\TransportInterface;
use Vemt\Jasper\Exception\JasperException;

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
     * @see Vemt\Jasper\Transport.TransportInterface::call()
     */
    public function call($name, $parameters)
    {
        $cli = $this->getSoap();

        $response =  $cli->call($name, $parameters);
//         var_dump($response); die();

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
            error_log("[Jasper-php] SOAP Error : " . $errorMessage );

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
     * @see Vemt\Jasper\Transport.TransportInterface::getUser()
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * (non-PHPdoc)
     * @see Vemt\Jasper\Transport.TransportInterface::setUser()
     */
    public function setUser($user)
    {
        $this->user = $user;
    }

    /**
     * (non-PHPdoc)
     * @see Vemt\Jasper\Transport.TransportInterface::getPassword()
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * (non-PHPdoc)
     * @see Vemt\Jasper\Transport.TransportInterface::setPassword()
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * (non-PHPdoc)
     * @see Vemt\Jasper\Transport.TransportInterface::getUrl()
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * (non-PHPdoc)
     * @see Vemt\Jasper\Transport.TransportInterface::setUrl()
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
        if (false === class_exists('Soap_Client')) {
            throw new JasperException('Pear::Soap package not installed or not in system path');
        }

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
     * @see Vemt\Jasper\Interfaces.TransportInterface::getRawResponse()
     */
    public function getRawResponse()
    {
        return $this->getSoap()->_soap_transport;
    }

}
