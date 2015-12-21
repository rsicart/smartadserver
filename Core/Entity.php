<?php

namespace Core;


abstract class Entity implements \JsonSerializable
{
    /**
     * Creates a new instance of a child class.
     * @param stdClass|Array $data
     * @return an instance of the child class
     */
    abstract public function createFromArray($data);

    public function isMethodAllowed($name)
    {
        $classMethods = get_class_methods($this);
        if ($name && $classMethods && in_array($name, $classMethods))
            return true;
        return false;
    }

    public function __toString()
    {
        return json_encode($this->jsonSerialize(), JSON_PRETTY_PRINT);
    }
}
