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
 * @author     Eric Zhou <eric@vemt.com>
 * @copyright  2013 VEMT – Value Exchange and Marketing Technology <http://www.vemt.com>
 * @license    http://www.opensource.org/licenses/mit-license.php MIT license
 */
namespace Vemt\Jasper\Resource\Permission;

use Vemt\Jasper\Resource\User\User;
use Vemt\Jasper\Resource\Role\Role;

/**
 * Jasper Permission Object
 *
 * @author Eric Zhou <eric@vemt.com>
 *
 */
class Permission
{
    public $uri = null;
    public $permissionRecipient = null;
    public $permissionMask = null;

    /**
     * Set resource uri
     *
     * @param String $uri resource uri
     */
	public function setUri($uri)
	{
		$this->uri = $uri;
	}
	/**
	 * Get resource uri
	 *
	 * @return String
	 */
	public function getUri()
	{
		return $this->uri;
	}
	/**
	 * Set permission recipient
	 *
	 * @param Object $object user or role object
	 */
    public function setPermissionRecipient($object)
    {
    	$this->permissionRecipient = $object;
    }
	/**
	 * Get permission recipient
	 *
	 * @return Object user or role
	 */
    public function getPermissionRecipient()
    {
        return $this->permissionRecipient;
    }
	/**
	 * Set Permission Mask
	 *
	 * @param int $default permissio code
	 *
	 * @example 0 = no access, 1 = administer 2 = ready-only
	 * @example 18 = read-delete, read-write-delete = 30
	 * @example 32 = execute-only
	 */
    public function setPermissionMask($default = 2)
    {
    	$this->permissionMask = $default;
    }

    /**
     * Get Permission Mask
     *
     * @return int
     */
    public function getPermissionMask()
    {
    	return $this->permissionMask;
    }
	/**
	 * Convert soap response to permission object
	 *
	 * @param Objecy $object soap response object
	 *
	 * @return Permission Object
	 */

    public static function fromObjet($object)
    {
		$permissionObj = new Permission();

		$properties = get_object_vars($object);

		foreach ($properties as $name => $defaultValue) {
			$setter = 'set' . ucfirst($name);
			if (method_exists($permissionObj, $setter)) {
				$permissionObj->$setter($object->$name);
			}
		}

		return $permissionObj;

    }
}
