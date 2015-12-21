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

    /**
     * Return a list of allowed methods
     * @return array
     */
    public function getAllowedMethods()
    {
        return static::$allowedMethods;
    }

    public function isAllowedMethod($name)
    {
        if ($name && in_array($name, $this->getAllowedMethods()))
            return true;
        return false;
    }

    public function __toString()
    {
        return json_encode($this->jsonSerialize(), JSON_PRETTY_PRINT);
    }
}
