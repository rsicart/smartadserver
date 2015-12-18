<?php

require_once(__DIR__ . '/../../Core/UserGroup.php');

use Core\UserGroup;


class UserGroupTest extends PHPUnit_Framework_TestCase
{

    public function testSetAndGetId()
    {
        $id = 1;
        $ug = new UserGroup();
        $ug->setId($id);

        $this->assertEquals($id, $ug->getId(), "Getter or setter doesn't work as expected");
    }

    public function testSetAndGetName()
    {
        $name = 'Libcaca';
        $ug = new UserGroup();
        $ug->setName($name);

        $this->assertEquals($name, $ug->getName(), "Getter or setter doesn't work as expected");
    }

    public function testToJson()
    {
        $id = 1;
        $name = 'Libcaca';
        $ug = new UserGroup();
        $ug->setId($id);
        $ug->setName($name);

        $data = json_decode($ug, false);

        $ugCopy = new UserGroup();
        $ugCopy->setId($data->id);
        $ugCopy->setName($data->name);

        $this->assertEquals($ug, $ugCopy, 'UserGroups are different');
    }
}
