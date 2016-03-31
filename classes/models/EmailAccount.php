<?php
/**
 * Created by PhpStorm.
 * User: markus
 * Date: 30.03.16
 * Time: 15:23
 */

namespace models;


class EmailAccount
{

    private $id;
    /**
     * @var User
     */
    private $user;
    /**
     * @var boolean
     */
    private $aktiv;
    private $autores_from;
    private $autores_fromname;
    /**
     * @var boolean
     */
    private $autores_singlesend;
    private $autores_spamlevel;
    private $autores_subject;
    private $autores_text;
    private $storage_percent;


    /**
     * EmailAccount constructor.
     * @param $id
     * @param User $user
     * @param $aktiv
     * @param $autores_from
     * @param $autores_fromname
     * @param bool $autores_singlesend
     * @param $autores_spamlevel
     * @param $autores_subject
     * @param $autores_text
     * @param $storage_percent
     */
    public function __construct($id, User $user, $aktiv, $autores_from, $autores_fromname, $autores_singlesend, $autores_spamlevel, $autores_subject, $autores_text, $storage_percent)
    {
        $this->id = $id;
        $this->user = $user;
        $this->aktiv = $aktiv;
        $this->autores_from = $autores_from;
        $this->autores_fromname = $autores_fromname;
        $this->autores_singlesend = $autores_singlesend;
        $this->autores_spamlevel = $autores_spamlevel;
        $this->autores_subject = $autores_subject;
        $this->autores_text = $autores_text;
        $this->storage_percent = $storage_percent;
    }

    /**
     * @return mixed
     */
    public function getStoragePercent()
    {
        return $this->storage_percent;
    }

    /**
     * @param mixed $storage_percent
     */
    public function setStoragePercent($storage_percent)
    {
        $this->storage_percent = $storage_percent;
    }


    /**
     * @return mixed
     */
    public function getAutoresText()
    {
        return $this->autores_text;
    }

    /**
     * @param mixed $autores_text
     */
    public function setAutoresText($autores_text)
    {
        $this->autores_text = $autores_text;
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
     * @return boolean
     */
    public function isAktiv()
    {
        return $this->aktiv;
    }

    /**
     * @param boolean $aktiv
     */
    public function setAktiv($aktiv)
    {
        $this->aktiv = $aktiv;
    }

    /**
     * @return mixed
     */
    public function getAutoresFrom()
    {
        return $this->autores_from;
    }

    /**
     * @param mixed $autores_from
     */
    public function setAutoresFrom($autores_from)
    {
        $this->autores_from = $autores_from;
    }

    /**
     * @return mixed
     */
    public function getAutoresFromname()
    {
        return $this->autores_fromname;
    }

    /**
     * @param mixed $autores_fromname
     */
    public function setAutoresFromname($autores_fromname)
    {
        $this->autores_fromname = $autores_fromname;
    }

    /**
     * @return boolean
     */
    public function isAutoresSinglesend()
    {
        return $this->autores_singlesend;
    }

    /**
     * @param boolean $autores_singlesend
     */
    public function setAutoresSinglesend($autores_singlesend)
    {
        $this->autores_singlesend = $autores_singlesend;
    }

    /**
     * @return mixed
     */
    public function getAutoresSpamlevel()
    {
        return $this->autores_spamlevel;
    }

    /**
     * @param mixed $autores_spamlevel
     */
    public function setAutoresSpamlevel($autores_spamlevel)
    {
        $this->autores_spamlevel = $autores_spamlevel;
    }

    /**
     * @return mixed
     */
    public function getAutoresSubject()
    {
        return $this->autores_subject;
    }

    /**
     * @param mixed $autores_subject
     */
    public function setAutoresSubject($autores_subject)
    {
        $this->autores_subject = $autores_subject;
    }



    public function toArray() {
        return array(
            "id" => $this->getId(),
            "user" => $this->getUser()->toArray(),
            "aktiv" => $this->isAktiv(),
            "autores_from" => $this->getAutoresFrom(),
            "autores_fromname" => $this->getAutoresFromname(),
            "autores_singlesend" => $this->isAutoresSinglesend(),
            "autores_spamlevel" => $this->getAutoresSpamlevel(),
            "autores_subject" => $this->getAutoresSubject(),
            "autores_text" => $this->getAutoresText(),
            "storage_percent" => $this->getStoragePercent()
        );
    }



}