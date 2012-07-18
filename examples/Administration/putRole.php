<?php
include __DIR__ . '/../bootstrap.php';

use Vemt\Jasper\Transport\SoapTransport;
use Vemt\Jasper\Request\Administration\PutRole;
use Vemt\Jasper\Resource\Role\Role;

// setup the soap transport
$cli = new SoapTransport($administrationUrl, $user, $password);

// executing the get resources request
$request = new PutRole($cli);

// specifying role to save
$role = new Role();
$role->setRoleName('ROLE_TESTING');
$role->setTenantId(null);
$request->setRole($role);

$resource = $request->execute();

echo "Saved user : \n" . var_export($resource, true);