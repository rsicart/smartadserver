<?php

require_once(__DIR__ . '/../../vendor/autoload.php');

use Core\UserGroup;
use Core\Language;
use Core\Site;


class SiteTest extends PHPUnit_Framework_TestCase
{

    public function testSetAndGetId()
    {
        $id = 1;
        $w = new Site();
        $w->setId($id);

        $this->assertEquals($id, $w->getId(), "Getter or setter doesn't work as expected");
    }

    public function testSetAndGetName()
    {
        $name = 'Libcaca';
        $w = new Site();
        $w->setName($name);

        $this->assertEquals($name, $w->getName(), "Getter or setter doesn't work as expected");
    }

    public function testSetAndGetUserGroup()
    {
        $ug = new UserGroup();
        $ug->setId(456);
        $ug->setName('UserGroup');

        $w = new Site();
        $w->setUserGroup($ug);

        $this->assertEquals($ug, $w->getUserGroup(), "Getter or setter doesn't work as expected");
    }

    public function testSetAndGetUrl()
    {
        $url = 'www.example.com';
        $w = new Site();
        $w->setUrl($url);

        $this->assertEquals($url, $w->getUrl(), "Getter or setter doesn't work as expected");
    }

    public function testSetAndGetLanguage()
    {
        $l = new Language();
        $l->setId(123);
        $l->setName('Language');

        $w = new Site();
        $w->setLanguage($l);

        $this->assertEquals($l, $w->getLanguage(), "Getter or setter doesn't work as expected");
    }

    public function testSetAndGetIsArchived()
    {
        $ia = true;
        $w = new Site();
        $w->setIsArchived($ia);

        $this->assertEquals($ia, $w->getIsArchived(), "Getter or setter doesn't work as expected");
    }

    public function testSetAndGetUpdatedAt()
    {
        $dt = new \DateTime();

        $w = new Site();
        $w->setUpdatedAt($dt);

        $this->assertEquals($dt, $w->getUpdatedAt(), "Getter or setter doesn't work as expected");
    }

    public function testToJson()
    {
        $l = new Language();
        $l->setId(123);
        $l->setName('Language');

        $ug = new UserGroup();
        $ug->setId(456);
        $ug->setName('UserGroup');

        $id = 1;
        $dt = new \DateTime();
        $w = new Site();
        $w->setId($id);
        $w->setName('Website');
        $w->setUserGroup($ug);
        $w->setUrl('www.example.com');
        $w->setLanguage($l);
        $w->setIsArchived(false);
        $w->setUpdatedAt($dt);


        $data = json_decode($w);

        $lCopy = new Language();
        $lCopy->setId($data->languageId);
        $lCopy->setName('Language');

        $ugCopy = new UserGroup();
        $ugCopy->setId($data->userGroupId);
        $ugCopy->setName('UserGroup');

        $dtCopy = new \DateTime($data->updatedAt);

        $wCopy = new Site();
        $wCopy->setId($data->id);
        $wCopy->setName($data->name);
        $wCopy->setUserGroup($ugCopy);
        $wCopy->setUrl('www.example.com');
        $wCopy->setLanguage($lCopy);
        $wCopy->setIsArchived($data->isArchived);
        $wCopy->setUpdatedAt($dtCopy);

        $this->assertEquals($w, $wCopy, "Websites are different");
    }

    public function testCreateFromArray()
    {
        $data = [
            'id' => 1,
            'name' => 'Libcaca',
            'userGroupId' => 234,
            'url' => 'www.example.com',
            'languageId' => 2,
            'isArchived' => true,
            'updatedAt' => '1984-06-01T07:34:00',
        ];

        $sFromArray = Site::createFromArray($data);
        $sFromObject = Site::createFromArray((object) $data);

        $this->assertInstanceOf('Core\Site', $sFromArray);
        $this->assertInstanceOf('Core\Site', $sFromObject);
        $this->assertEquals($sFromArray, $sFromObject, 'Sites are different');
        $this->assertEquals(1, $sFromArray->getId());
        $this->assertEquals(1, $sFromObject->getId());
    }

    public function testGetAllowedMethods()
    {
        $id = 1;
        $name = 'Libcaca';
        $s = new Site();
        $s->setId($id);
        $s->setName($name);

        $allowed = ['fetchAll', 'fetch', 'create', 'update', 'delete',];

        $this->assertEquals($allowed, $s->getAllowedMethods());
    }

    /**
     * @dataProvider isAllowedMethodProvider
     */
    public function testIsAllowedMethod($method, $expected)
    {
        $id = 1;
        $name = 'Libcaca';
        $s = new Site();
        $s->setId($id);
        $s->setName($name);

        $this->assertEquals($expected, $s->isAllowedMethod($method));
    }

    public function isAllowedMethodProvider()
    {
        // method name, boolean result
        return [
            ['fetchAll', true],
            ['fetch', true],
            ['create', true],
            ['update', true],
            ['delete', true],
        ];
    }
}
