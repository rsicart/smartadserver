<?php

namespace Core;


class Language extends Entity
{
    /**
     * @var $allowedMethods list of allowed methods
     */
    protected static $allowedMethods = ['fetchAll',];

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

    public function createFromArray($data)
    {
        $data = (object) $data;

        $instance = new Language();
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
