<?php
include __DIR__ . '/../bootstrap.php';

use Vemt\Jasper\Transport\SoapTransport;
use Vemt\Jasper\Request\Administration\FindUsers;
use Vemt\Jasper\Resource\User\UserSearchCriteria;

// setup the soap transport
$cli = new SoapTransport($administrationUrl, $user, $password);

// executing the get resources request
$request = new FindUsers($cli);

// this is the default behaviour, search for all users
$request->setSearchCriteria(new UserSearchCriteria());

$resources = $request->execute();

foreach ($resources as $user) {
    echo sprintf("\nUsername: %s\nName: %s\n", $user->getUserName(), $user->getFullName());
    echo "Roles:\n";
    foreach ($user->getRoles() as $role) {
        echo sprintf("  %s\n", $role->getRoleName());
    }
}
