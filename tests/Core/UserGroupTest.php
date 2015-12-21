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

    public function testCreateFromArray()
    {
        $data = [
            'id' => 1,
            'name' => 'Libcaca',
        ];

        $ugFromArray = UserGroup::createFromArray($data);
        $ugFromObject = UserGroup::createFromArray((object) $data);

        $this->assertInstanceOf('Core\UserGroup', $ugFromArray);
        $this->assertInstanceOf('Core\UserGroup', $ugFromObject);
        $this->assertEquals($ugFromArray, $ugFromObject, 'UserGroups are different');
        $this->assertEquals(1, $ugFromArray->getId());
        $this->assertEquals(1, $ugFromObject->getId());
    }

    public function testGetAllowedMethods()
    {
        $id = 1;
        $name = 'Libcaca';
        $ug = new UserGroup();
        $ug->setId($id);
        $ug->setName($name);

        $allowed = ['fetchAll',];

        $this->assertEquals($allowed, $ug->getAllowedMethods());
    }

    /**
     * @dataProvider isAllowedMethodProvider
     */
    public function testIsAllowedMethod($method, $expected)
    {
        $id = 1;
        $name = 'Libcaca';
        $ug = new UserGroup();
        $ug->setId($id);
        $ug->setName($name);

        $this->assertEquals($expected, $ug->isAllowedMethod($method));
    }

    public function isAllowedMethodProvider()
    {
        // method name, boolean result
        return [
            ['fetchAll', true],
            ['fetch', false],
            ['create', false],
            ['update', false],
            ['delete', false],
        ];
    }
}
