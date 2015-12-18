<?php

namespace Core;


abstract class Entity implements \JsonSerializable
{
    public function jsonSerialize()
    {
        return \get_object_vars($this);
    }

    public function __toString()
    {
        return json_encode($this->jsonSerialize(), JSON_PRETTY_PRINT);
    }
}
