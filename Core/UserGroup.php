<?php

namespace Core;

use Serializer\JsonSerializer;


class UserGroup implements JsonSerializer
{
    /**
     * @var $id int
     */
    private $id;

    /**
     * @var $name string
     */
    private $name;


    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        return $this->id = $id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        return $this->name = $name;
    }


    public function jsonSerialize()
    {
        return \get_object_vars($this);
    }

    public function toJson()
    {
        return json_encode($this->jsonSerialize(), JSON_PRETTY_PRINT);
    }
}
