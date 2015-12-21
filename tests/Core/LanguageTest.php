<?php

require_once(__DIR__ . '/../../vendor/autoload.php');

use Core\Language;


class LanguageTest extends PHPUnit_Framework_TestCase
{

    public function testSetAndGetId()
    {
        $id = 1;
        $l = new Language();
        $l->setId($id);

        $this->assertEquals($id, $l->getId(), "Getter or setter doesn't work as expected");
    }

    public function testSetAndGetName()
    {
        $name = 'Libcaca';
        $l = new Language();
        $l->setName($name);

        $this->assertEquals($name, $l->getName(), "Getter or setter doesn't work as expected");
    }

    public function testToJson()
    {
        $id = 1;
        $name = 'Libcaca';
        $l = new Language();
        $l->setId($id);
        $l->setName($name);

        $data = json_decode($l, false);

        $lCopy = new Language();
        $lCopy->setId($data->id);
        $lCopy->setName($data->name);

        $this->assertEquals($l, $lCopy, 'Languages are different');
    }

    public function testCreateFromArray()
    {
        $data = [
            'id' => 1,
            'name' => 'Libcaca',
        ];

        $lFromArray = Language::createFromArray($data);
        $lFromObject = Language::createFromArray((object) $data);

        $this->assertInstanceOf('Core\Language', $lFromArray);
        $this->assertInstanceOf('Core\Language', $lFromObject);
        $this->assertEquals($lFromArray, $lFromObject, 'Languages are different');
        $this->assertEquals(1, $lFromArray->getId());
        $this->assertEquals(1, $lFromObject->getId());
    }

    public function testGetAllowedMethods()
    {
        $id = 1;
        $name = 'Libcaca';
        $l = new Language();
        $l->setId($id);
        $l->setName($name);

        $allowed = ['fetchAll',];

        $this->assertEquals($allowed, $l->getAllowedMethods());
    }

    /**
     * @dataProvider isAllowedMethodProvider
     */
    public function testIsAllowedMethod($method, $expected)
    {
        $id = 1;
        $name = 'Libcaca';
        $l = new Language();
        $l->setId($id);
        $l->setName($name);

        $this->assertEquals($expected, $l->isAllowedMethod($method));
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
