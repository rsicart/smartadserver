<?php

namespace Core;


class Website extends Entity
{
    /**
     * @var $id int
     */
    protected $id;

    /**
     * @var $name string
     */
    protected $name;

    /**
     * @var $userGroup UserGroup
     */
    protected $userGroup;

    /**
     * @var $url string
     */
    protected $url;

    /**
     * @var $language Language
     */
    protected $language;

    /**
     * @var $isArchived boolean
     */
    protected $isArchived;

    /**
     * @var $updatedAt DateTime
     */
    protected $updatedAt;


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

    public function getUserGroup()
    {
        return $this->userGroup;
    }

    public function setUserGroup(UserGroup $userGroup)
    {
        return $this->userGroup = $userGroup;
    }

    public function getUrl()
    {
        return $this->url;
    }

    public function setUrl($url)
    {
        return $this->url = $url;
    }

    public function getLanguage()
    {
        return $this->language;
    }

    public function setLanguage(Language $language)
    {
        return $this->language = $language;
    }

    public function getIsArchived()
    {
        return $this->isArchived;
    }

    public function setIsArchived($isArchived)
    {
        return $this->isArchived = $isArchived;
    }

    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTime $updatedAt)
    {
        return $this->updatedAt = $updatedAt;
    }


    public function jsonSerialize()
    {
        // custom
        return [
            'id' => $this->getId(),
            'name' => $this->getName(),
            'userGroupId' => $this->getUserGroup()->getId(),
            'url' => $this->getUrl(),
            'languageId' => $this->getLanguage()->getId(),
            'isArchived' => $this->getIsArchived(),
            'updatedAt' => $this->getUpdatedAt()->format(\DateTime::ATOM),
        ];
    }
}
