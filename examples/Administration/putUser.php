<?php
use Vemt\Jasper\Resource\Role\Role;

include __DIR__ . '/../bootstrap.php';

use Vemt\Jasper\Transport\SoapTransport;
use Vemt\Jasper\Request\Administration\PutUser;
use Vemt\Jasper\Resource\User\User;

// setup the soap transport
$cli = new SoapTransport($administrationUrl, $user, $password);

// executing the get resources request
$request = new PutUser($cli);

// specifying user to save
$user = new User();
$user->setUsername('test');
$user->setPassword('test1234!');
$user->setFullName('test user');
$user->setEmailAddress('test@foo.com');
$user->setExternallyDefined(false);
$user->setEnabled(true);
$user->setTenantId(null);

$role = new Role();
$role->setRoleName('ROLE_ANONYMOUS');
$role->setTenantId(null);
$user->addRole($role);

$request->setUser($user);

$resource = $request->execute();

echo "Saved user : \n" . var_export($resource, true);
