<?php

require_once(__DIR__ . '/../../Core/Client.php');

use Core\Client;
use Core\Language;
use Core\UserGroup;
use Core\Site;


class ClientTest extends PHPUnit_Framework_TestCase
{

    public function testSetAndGetNetworkId()
    {
        $id = 1;
        $c = new Client();
        $c->setNetworkId($id);

        $this->assertEquals($id, $c->getNetworkId(), "Getter or setter doesn't work as expected");
    }

    public function testSetAndGetApiUrl()
    {
        $url = 'http://api.example.com';
        $c = new Client();
        $c->setApiUrl($url);

        $this->assertEquals($url, $c->getApiUrl(), "Getter or setter doesn't work as expected");
    }

    public function testSetAndGetLogin()
    {
        $login = 'apiUser';
        $c = new Client();
        $c->setLogin($login);

        $this->assertEquals($login, $c->getLogin(), "Getter or setter doesn't work as expected");
    }

    public function testSetAndGetPassword()
    {
        $password = 'p@ssw0rd';
        $c = new Client();
        $c->setPassword($password);

        $this->assertEquals($password, $c->getPassword(), "Getter or setter doesn't work as expected");
    }

    public function testGetCredentials()
    {
        $login = 'apiUser';
        $password = 'p@ssw0rd';
        $c = new Client();
        $c->setLogin($login);
        $c->setPassword($password);

        $expected = base64_encode(sprintf('%s:%s', $c->getLogin(), $c->getPassword()));
        $this->assertEquals($expected, $c->getCredentials(), "Getter doesn't work as expected");
    }

    /**
     * @dataProvider getEndpointNameProvider
     */
    public function testGetEndpointName($instance, $name, $expected)
    {
        $c = new Client();
        $this->assertEquals($expected, $c->getEndpointName($instance, $name));
    }

    public function getEndpointNameProvider()
    {
        $l = Language::createFromArray(['id' => 1, 'name' => 'French']);
        $ug = UserGroup::createFromArray(['id' => 1, 'name' => 'UserGroup Test']);
        $s = Site::createFromArray([
            'id' => 1,
            'name' => 'Example Site',
            'userGroupId' => 2,
            'url' => 'http://example.com',
            'languageId' => 3,
            'updatedAt' => '1984-06-01 07:32:23',
            'isArchived' => true,
        ]);

        // instance, name, expected
        return [
            [$l, null, 'languages'],
            [$ug, null, 'usergroups'],
            [$s, null, 'sites'],
            [$s, 'customname', 'customname'],
        ];
    }
}
