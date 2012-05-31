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
namespace Vemt\Jasper\Interfaces;

/**
 * Minimal functionality for a Transport client (HTTP, REST, SOAP, etc...).
 *
 * @author Nuno Costa <nuno@Vemt.com>
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
     * after a call() has been executes this function will return the raw response.
     *
     * @return string
     */
    public function getRawResponse();
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