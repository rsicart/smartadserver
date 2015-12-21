<?php

namespace Core;


class UserGroup extends Entity
{
    /**
     * @var $id int
     */
    protected $id;

    /**
     * @var $name string
     */
    protected $name;


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

    public function createFromArray($url, $data)
    {
        $data = (object) $data;

        $instance = new UserGroup();
        $instance->setApiUrl($url);
        $instance->setId($data->id);
        $instance->setName($data->name);

        return $instance;
    }

    public function jsonSerialize()
    {
        return [
            'id' => $this->getId(),
            'name' => $this->getName(),
        ];
    }
}
