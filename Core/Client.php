<?php

namespace Core;


class Client
{
    /**
     * @var $networkId string
     */
    private $networkId;

    /**
     * @var $apiUrl string api base url
     */
    private $apiUrl;

    /**
     * @var $login string api login
     */
    private $login;

    /**
     * @var $password string api password
     */
    private $password;

    /**
     * Sets network id.
     * @param string $id
     */
    public function setNetworkId($id)
    {
        $this->networkId = $id;
    }

    /**
     * Gets network id.
     * @return string
     */
    public function getNetworkId()
    {
        return $this->networkId;
    }

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
     * Sets api login.
     * @param string $login
     */
    public function setLogin($login)
    {
        $this->login = $login;
    }

    /**
     * Gets api login.
     * @return string $login
     */
    public function getLogin()
    {
        return $this->login;
    }

    /**
     * Sets api password.
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * Gets api password.
     * @return string $password
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Gets api credentials, ready to be used with basic auth header.
     * @return string
     */
    public function getCredentials()
    {
        return base64_encode(sprintf("%s:%s", $this->getLogin(), $this->getPassword()));
    }

    /**
     * Gets api endpoint, without base url.
     * @return string
     */
    public function getEndpointName(Entity $instance, $name = null)
    {
        // lowercase and pluralize
        if (!$name) {
            $nonQualifiedClass = str_replace(__NAMESPACE__ . '\\', '', get_class($instance));
            $name = sprintf('%ss', strtolower($nonQualifiedClass));
        }
        return $name;
    }

    public function fetchAll(Entity $instance, $ids)
    {
        if (!$instance->isAllowedMethod(__METHOD__))
            throw new \DomainException(__METHOD__ . ' not allowed on this entity.');

        throw new \Exception('Not implemented');
    }

    public function fetch(Entity $instance)
    {
        if (!$instance->isAllowedMethod(__METHOD__))
            throw new \DomainException(__METHOD__ . ' not allowed on this entity.');

        throw new \Exception('Not implemented');
    }

    public function create(Entity $instance)
    {
        if (!$instance->isAllowedMethod(__METHOD__))
            throw new \DomainException(__METHOD__ . ' not allowed on this entity.');

        throw new \Exception('Not implemented');
    }

    public function update(Entity $instance)
    {
        if (!$instance->isAllowedMethod(__METHOD__))
            throw new \DomainException(__METHOD__ . ' not allowed on this entity.');

        throw new \Exception('Not implemented');
    }

    public function delete(Entity $instance)
    {
        if (!$instance->isAllowedMethod(__METHOD__))
            throw new \DomainException(__METHOD__ . ' not allowed on this entity.');

        throw new \Exception('Not implemented');
    }
}
