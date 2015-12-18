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

    public function jsonSerialize()
    {
        return \get_object_vars($this);
    }

    public function getEndpointName()
    {
        $nonQualifiedClass = str_replace(__NAMESPACE__ . '\\', '', get_class($this));
        return sprintf('%ss', strtolower($nonQualifiedClass));
    }

    public function __toString()
    {
        return json_encode($this->jsonSerialize(), JSON_PRETTY_PRINT);
    }
}
