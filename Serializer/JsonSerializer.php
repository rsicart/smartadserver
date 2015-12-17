<?php

namespace Serializer;


interface JsonSerializer extends \JsonSerializable
{
    public function toJson();
}
