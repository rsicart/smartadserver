<?php

namespace Core;


abstract class Entity implements \JsonSerializable
{
    /**
     * @var $apiUrl string api base url
     */
    private $apiUrl;

    /**
     * Creates a new instance of a child class.
     * @param string $url api base url
     * @param stdClass|Array $data
     * @return an instance of the child class
     */
    abstract public function createFromArray($url, $data);

    /**
     * Sets http api base url.
     * @param string $url api base url
     */
    public function setApiUrl($url)
    {
        if (!filter_var($url, FILTER_VALIDATE_URL) || stripos($url, 'http', 0) === false)
            throw new \InvalidArgumentException('Invalid url.');
        $this->apiUrl = $url;
    }

    /**
     * Gets api base url.
     */
    public function getApiUrl()
    {
        return $this->apiUrl;
    }

    /**
     * Gets api endpoint, without base url.
     * @return string
     */
    public function getEndpointName($name = null)
    {
        // lowercase and pluralize
        if (!$name) {
            $nonQualifiedClass = str_replace(__NAMESPACE__ . '\\', '', get_class($this));
            $name = sprintf('%ss', strtolower($nonQualifiedClass));
        }
        return $name;
    }

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
