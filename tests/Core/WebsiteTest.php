<?php

require_once(__DIR__ . '/../../vendor/autoload.php');

use Core\UserGroup;
use Core\Language;
use Core\Website;


class WebsiteTest extends PHPUnit_Framework_TestCase
{

    public function testSetAndGetId()
    {
        $id = 1;
        $w = new Website();
        $w->setId($id);

        $this->assertEquals($id, $w->getId(), "Getter or setter doesn't work as expected");
    }

    public function testSetAndGetName()
    {
        $name = 'Libcaca';
        $w = new Website();
        $w->setName($name);

        $this->assertEquals($name, $w->getName(), "Getter or setter doesn't work as expected");
    }

    public function testSetAndGetUserGroup()
    {
        $ug = new UserGroup();
        $ug->setId(456);
        $ug->setName('UserGroup');

        $w = new Website();
        $w->setUserGroup($ug);

        $this->assertEquals($ug, $w->getUserGroup(), "Getter or setter doesn't work as expected");
    }

    public function testSetAndGetUrl()
    {
        $url = 'www.example.com';
        $w = new Website();
        $w->setUrl($url);

        $this->assertEquals($url, $w->getUrl(), "Getter or setter doesn't work as expected");
    }

    public function testSetAndGetLanguage()
    {
        $l = new Language();
        $l->setId(123);
        $l->setName('Language');

        $w = new Website();
        $w->setLanguage($l);

        $this->assertEquals($l, $w->getLanguage(), "Getter or setter doesn't work as expected");
    }

    public function testSetAndGetIsArchived()
    {
        $ia = true;
        $w = new Website();
        $w->setIsArchived($ia);

        $this->assertEquals($ia, $w->getIsArchived(), "Getter or setter doesn't work as expected");
    }

    public function testSetAndGetUpdatedAt()
    {
        $dt = new \DateTime();

        $w = new Website();
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
        $w = new Website();
        $w->setId($id);
        $w->setName('Website');
        $w->setUserGroup($ug);
        $w->setUrl('www.example.com');
        $w->setLanguage($l);
        $w->setIsArchived(false);
        $w->setUpdatedAt($dt);


        $json = $w->toJson();
        $data = json_decode($json);

        $lCopy = new Language();
        $lCopy->setId($data->languageId);
        $lCopy->setName('Language');

        $ugCopy = new UserGroup();
        $ugCopy->setId($data->userGroupId);
        $ugCopy->setName('UserGroup');

        $dtCopy = new DateTime($data->updatedAt);

        $wCopy = new Website();
        $wCopy->setId($data->id);
        $wCopy->setName($data->name);
        $wCopy->setUserGroup($ugCopy);
        $wCopy->setUrl('www.example.com');
        $wCopy->setLanguage($lCopy);
        $wCopy->setIsArchived($data->isArchived);
        $wCopy->setUpdatedAt($dtCopy);

        $this->assertEquals($w, $wCopy, "Websites are different");    }
}
