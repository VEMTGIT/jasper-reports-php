#jasper-reports-php

jasper reports php library

Pure php library for jasper reports

##Requirements

 * PHP 5.3
 * SOAP pear package (http://pear.php.net/package/SOAP/)
 * Net_Dime pear package (http://pear.php.net/package/Net_DIME/)

#Usage
##Repository Operations
### Listing resources on the server:

```php
<?php

    use francodacosta\Jasper\Transport\SoapTransport;
    use francodacosta\Jasper\Request\Repository\ListResources;
    
    // setup the soap transport
    $cli = new SoapTransport($repositoryUrl, $user, $password);
    
    // executing the list resources request
    $request = new ListResources($cli);
    $request->setUri('/');
    $resources = $request->execute();
    
    
    echo "Listing resources Resources at " . $request->getUri();
    foreach($resources as $resource) {
        echo $resource . "\n";
    }
```

### Getting information about a resource

```php
<?php

    use francodacosta\Jasper\Transport\SoapTransport;
    use francodacosta\Jasper\Request\Repository\GetResource;
    
    // setup the soap transport
    $cli = new SoapTransport($repositoryUrl, $user, $password);
    
    // executing the get resources request
    $request = new GetResource($cli);
    $request->setUri('/');
    $resource = $request->execute();
    
    
    // display data
    echo $resource . "\n";
    
    echo "Attachments:\n";
    if ($resource->hasAttachments()) {
        foreach ($resource->getAttachments() as $attachment) {
            // an attachment is another resource object
            echo "\t $attachment \n";
        }
    } else {
        echo "none\n";
    }

```

### Executing a report

```php
<?php

    use francodacosta\Jasper\Transport\SoapTransport;
    use francodacosta\Jasper\Request\Repository\RunReport;
    
    // setup the soap transport
    $cli = new SoapTransport($repositoryUrl, $user, $password);
    
    // executing the get resources request
    $request = new RunReport($cli);
    $request->setUri('/report_unit_uri');
    
    //setting the report type to html
    $request->addExtraArgument('RUN_OUTPUT_FORMAT', 'HTML');
    
    //adding parameters to the report
    $request->addParameter('parameter 1', 'value 1');
    
    
    $resource = $request->execute();
    
    
    
    // display data
    if ($resource->hasAttachments()) {
        foreach ($resource->getAttachments() as $name => $attachment) {
            // the report itself has the key 'cid:report'
            // images are also attached
            echo "\t $name => $attachment \n";
        }
    } else {
        echo "no report returned\n";
    }

```
##Administration operations
###Searching users
```php
<?php
    use francodacosta\Jasper\Transport\SoapTransport;
    use francodacosta\Jasper\Request\Administration\FindUsers;
    use francodacosta\Jasper\Resource\User\UserSearchCriteria;
    
    // setup the soap transport
    $cli = new SoapTransport($administrationUrl, $user, $password);
    
    // executing the get resources request
    $request = new FindUsers($cli);
    
    // this is the default behaviour, search for all users
    $request->setSearchCriteria(new UserSearchCriteria());
    
    $resources = $request->execute();
```

###Adding/Modifying an user

```php
<?php
    use francodacosta\Jasper\Transport\SoapTransport;
    use francodacosta\Jasper\Request\Administration\PutUser;
    use francodacosta\Jasper\Resource\User\User;
    
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
```
###Searching roles

```php
<?php
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
```