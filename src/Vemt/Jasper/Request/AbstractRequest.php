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
namespace Vemt\Jasper\Request;
use Vemt\Jasper\Interfaces\RequestInterface;
use Vemt\Jasper\Interfaces\TransportInterface;

/**
 * Helper functions for request objects.
 *
 * @author Nuno Costa <nuno@Vemt.com>
 *
 */
Abstract class AbstractRequest implements RequestInterface
{
    private $cli;

    /**
     * (non-PHPdoc)
     * @see Vemt\Jasper\Interfaces.RequestInterface::__construct()
     */
    public function __construct(TransportInterface $transport)
    {
        $this->setCli($transport);
    }

    /**
     * (non-PHPdoc)
     * @see Vemt\Jasper\Interfaces.RequestInterface::execute()
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
