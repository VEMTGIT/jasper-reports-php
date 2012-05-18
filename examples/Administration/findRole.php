<?php
include __DIR__ . '/../bootstrap.php';

use francodacosta\Jasper\Transport\SoapTransport;
use francodacosta\Jasper\Request\Administration\FindRoles;
use francodacosta\Jasper\Resource\Role\RoleSearchCriteria;

// setup the soap transport
$cli = new SoapTransport($administrationUrl, $user, $password);

// executing the get resources request
$request = new FindRoles($cli);

// this is the default behaviour, search for all roles
$request->setSearchCriteria(new RoleSearchCriteria());

$resources = $request->execute();


foreach ($resources as $role) {
        echo sprintf("%s\n", $role->getRoleName());
    $users = $role->getUsers();
    if (is_array($users)) {
        echo "Users:\n";
        foreach ($users as $user) {
            echo sprintf("  Username: %s\nName: %s\n", $user->getUserName(), $user->getFullName());
        }
    }
}
