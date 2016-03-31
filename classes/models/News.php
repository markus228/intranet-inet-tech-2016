<?php
/**
 * Created by PhpStorm.
 * User: markus
 * Date: 30.03.16
 * Time: 09:16
 */

namespace models;

/**
 * Class News
 * @package models
 *
 * Model für die Neuigkeiten
 */
class News
{



    private $id;
    /**
     * @var User
     */
    private $user;
    /**
     * @var \DateTime
     */
    private $datetime;
    private $content;


    public function __construct($id, User $user, \DateTime $dateTime, $content) {
        $this->id = $id;
        $this->user = $user;
        $this->datetime = $dateTime;
        $this->content = $content;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param User $user
     */
    public function setUser($user)
    {
        $this->user = $user;
    }

    /**
     * @return \DateTime
     */
    public function getDatetime()
    {
        return $this->datetime;
    }

    /**
     * @param \DateTime $datetime
     */
    public function setDatetime($datetime)
    {
        $this->datetime = $datetime;
    }

    /**
     * @return mixed
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param mixed $content
     */
    public function setContent($content)
    {
        $this->content = $content;
    }


    /**
     * Gibt den Inhalt des Objekts als Array aus.
     * @return array
     */
    public function toArray() {
        return array(
            "id" => $this->getId(),
            "user" => $this->getUser()->toArray(),
            "datetime" => $this->getDatetime()->format(\DateTime::ISO8601),
            "content" => $this->getContent()
        );
    }


}