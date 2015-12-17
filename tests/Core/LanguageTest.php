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

        $json = $l->toJson();
        $data = json_decode($json, false);

        $lCopy = new Language();
        $lCopy->setId($data->id);
        $lCopy->setName($data->name);

        $this->assertEquals($l, $lCopy, 'Languages are different');
    }
}
