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
     * Checks if a given url is valid
     * @param string $url
     * @return boolean
     */
    protected function isValidUrl($url)
    {
        return (filter_var($url, FILTER_VALIDATE_URL) && stripos($url, 'http', 0) !== false);
    }

    /**
     * Sets http api base url.
     * @param string $url api base url
     */
    public function setApiUrl($url)
    {
        if (!$this->isValidUrl($url))
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
    /**
     * Creates a new instance of Client
     * @param array $options
     * @return Client
     */
    public function createFromArray($options)
    {
        $instance = new Client();
        $instance->setNetworkId($options['networkId']);
        $instance->setApiUrl($options['url']);
        $instance->setLogin($options['login']);
        $instance->setPassword($options['password']);

        return $instance;
    }

    /**
     * Returns the unique id from a created entity, extracted from an url.
     * @param Entity $instance
     * @param string $url
     * @return integer|null
     */
    public function getCreatedEntityId(Entity $instance, $url)
    {
        if (!$this->isValidUrl($url))
            throw new \InvalidArgumentException('Invalid url.');

        $components = parse_url($url);
        if (!isset($components['path']))
            throw new \InvalidArgumentException('Invalid url.');

        $pathComponents = explode('/', $components['path']);
        list($endpointName, $id) = array_slice($pathComponents, -2);

        if ($endpointName == $this->getEndpointName($instance) && is_numeric($id))
            return $id;

        return null;
    }

    /**
     * Get a list of entities.
     * @param Entity $instance
     * @param array $ids
     * @return <array>Entity
     */
    public function fetchAll(Entity $instance, array $ids = [])
    {
        if (!$instance->isAllowedMethod(__FUNCTION__))
            throw new \DomainException(__FUNCTION__ . ' not allowed on this entity.');

        $url = sprintf('%s/%s/%s', $this->getApiUrl(), $this->getNetworkId(), $this->getEndpointName($instance));

        // add querystring
        if ($ids) {
            $qs = implode(',', $ids);
            $url = sprintf('%s?ids=%s', $url, $qs);
        }

        $response = \Httpful\Request::get($url)
            ->authenticateWith($this->getLogin(), $this->getPassword())
            ->parseWith(function ($body) use ($instance) {
                $list = [];
                foreach ((array) json_decode($body, true) as $element)
                    $list[] = $instance->createFromArray($element);
                return $list;
            })
            ->send();

        if ($response->hasErrors()) {
            $exception = json_decode($response->body);
            throw new \UnexpectedValueException(sprintf("API response raised a '%s' exception with a message: '%s'. Status code %s", $exception->name, $exception->message, $response->code));
        }

        return $response->body;
    }

    /**
     * Get a specific entity.
     * @param Entity $instance
     * @return Entity
     */
    public function fetch(Entity $instance)
    {
        if (!$instance->isAllowedMethod(__FUNCTION__))
            throw new \DomainException(__FUNCTION__ . ' not allowed on this entity.');

        $url = sprintf('%s/%s/%s/%s', $this->getApiUrl(), $this->getNetworkId(), $this->getEndpointName($instance), $instance->getId());

        $response = \Httpful\Request::get($url)
            ->authenticateWith($this->getLogin(), $this->getPassword())
            ->parseWith(function ($body) use ($instance) {
                return $instance->createFromArray((array) json_decode($body, true));
            })
            ->send();

        if ($response->hasErrors()) {
            $exception = json_decode($response->body);
            throw new \UnexpectedValueException(sprintf("API response raised a '%s' exception with a message: '%s'. Status code %s", $exception->name, $exception->message, $response->code));
        }

        return $response->body;
    }

    /**
     * Creates a new entity.
     * Note: to obtain the created entity id, we use the http response header 'Location'
     * @param Entity $instance
     * @return Entity
     */
    public function create(Entity $instance)
    {
        if (!$instance->isAllowedMethod(__FUNCTION__))
            throw new \DomainException(__FUNCTION__ . ' not allowed on this entity.');

        $url = sprintf('%s/%s/%s', $this->getApiUrl(), $this->getNetworkId(), $this->getEndpointName($instance));

        $response = \Httpful\Request::post($url)
            ->authenticateWith($this->getLogin(), $this->getPassword())
            ->sendsJson()
            ->body($instance)
            ->send();

        if ($response->hasErrors()) {
            $exception = json_decode($response->body);
            throw new \UnexpectedValueException(sprintf("API response raised a '%s' exception with a message: '%s'. Status code %s", $exception->name, $exception->message, $response->code));
        }

        // get unique id of created entity and update entity's id
        if (!isset($response->headers['location']))
            throw new \UnexpectedValueException(sprintf('API response didn\'t send the created id. Status code %s', $response->code));

        $id = $this->getCreatedEntityId($instance, $response->headers['location']);
        $instance->setId($id);

        return $instance;
    }

    /**
     * Updates an existing entity.
     * @param Entity $instance
     * @return Entity
     */
    public function update(Entity $instance)
    {
        if (!$instance->isAllowedMethod(__FUNCTION__))
            throw new \DomainException(__FUNCTION__ . ' not allowed on this entity.');

        $url = sprintf('%s/%s/%s', $this->getApiUrl(), $this->getNetworkId(), $this->getEndpointName($instance));

        $response = \Httpful\Request::put($url)
            ->authenticateWith($this->getLogin(), $this->getPassword())
            ->sendsJson()
            ->body($instance)
            ->send();

        if ($response->hasErrors()) {
            $exception = json_decode($response->body);
            throw new \UnexpectedValueException(sprintf("API response raised a '%s' exception with a message: '%s'. Status code %s", $exception->name, $exception->message, $response->code));
        }

        return $instance;
    }

    public function delete(Entity $instance)
    {
        if (!$instance->isAllowedMethod(__FUNCTION__))
            throw new \DomainException(__FUNCTION__ . ' not allowed on this entity.');

        $url = sprintf('%s/%s/%s/%s', $this->getApiUrl(), $this->getNetworkId(), $this->getEndpointName($instance), $instance->getId());

        $response = \Httpful\Request::delete($url)
            ->authenticateWith($this->getLogin(), $this->getPassword())
            ->send();

        if ($response->hasErrors()) {
            $exception = json_decode($response->body);
            throw new \UnexpectedValueException(sprintf("API response raised a '%s' exception with a message: '%s'. Status code %s", $exception->name, $exception->message, $response->code));
        }

        return $instance;
    }
}
