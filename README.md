# Smart AdServer Client

## Requirements

* PHP
* Composer
* Httpful (PHP HTTP client)

## Example

```
<?php
require_once(__DIR__ . '/vendor/autoload.php');

use Core\UserGroup;
use Core\Language;
use Core\Site;
use Core\Client;

// create entities
$ug = new UserGroup();
$ug->setId(1);
$ug->setName('Example Group');

$l = new Language();
$l->setId(1);
$l->setName('Français');

$w = new Site();
$w->setId(0);
$w->setName('Example Site');
$w->setUserGroup($ug);
$w->setUrl('www.example.com');
$w->setLanguage($l);
$w->setIsArchived(false);
$w->setUpdatedAt(new DateTime());

// create and setup client
$c = new Client();
$c->setNetworkId('current');
$c->setApiUrl('https://manage.smartadserverapis.com');
$c->setLogin('user');
$c->setPassword('p@ssw0rd');

// do stuff
$w = $c->create($w);
$w->setName('Example Site 2');
$w2 = $c->create($w2);
$w2->setName('Example Site 2 Updated');
$w2 = $c->update($w2);
$w = $c->delete($w);
var_dump($c->fetchAll($w));
```
