<?php

namespace Core;


abstract class Entity implements \JsonSerializable
{
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
