<?php
/**
 * Created by PhpStorm.
 * User: markus
 * Date: 28.12.15
 * Time: 17:02
 */

namespace models;


class User
{
    private $id;
    private $username;
    private $vorname;
    private $nachname;
    private $strasse;
    private $hausnr;
    private $plz;
    private $ort;
    private $telefonDurchwahl;
    private $telefonPrivat;
    private $telefonMobil;
    private $mailAdressen = array();
    private $lastLogin;

    /**
     * User constructor.
     * @param $id
     * @param $username
     * @param $vorname
     * @param $nachname
     * @param $strasse
     * @param $hausnr
     * @param $plz
     * @param $ort
     * @param $telefonDurchwahl
     * @param $telefonPrivat
     * @param $telefonMobil
     * @param $mailAdressen
     */
    public function __construct($id, $username, $vorname, $nachname, $strasse, $hausnr, $plz, $ort, $telefonDurchwahl, $telefonPrivat, $telefonMobil, array $mailAdressen, $lastLogin)
    {
        $this->id = $id;
        $this->username = $username;
        $this->vorname = $vorname;
        $this->nachname = $nachname;
        $this->telefonMobil = $telefonMobil;
        $this->telefonPrivat = $telefonPrivat;
        $this->telefonDurchwahl = $telefonDurchwahl;
        $this->strasse = $strasse;
        $this->hausnr = $hausnr;
        $this->plz = $plz;
        $this->ort = $ort;
        $this->nachname = $nachname;
        $this->mailAdressen = $mailAdressen;
        $this->lastLogin = $lastLogin;
    }

    /**
     * Gibt den Usernamen des Nutzers
     * @return mixed
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param mixed $username
     * @return User
     */
    public function setUsername($username)
    {
        $this->username = $username;
        return $this;
    }

    /**
     * Gibt die User ID des Nutzers
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     * @return User
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * Gibt den Vornamen des Nutzers
     * @return mixed
     */
    public function getVorname()
    {
        return $this->vorname;
    }

    /**
     * @param mixed $vorname
     * @return User
     */
    public function setVorname($vorname)
    {
        $this->vorname = $vorname;
        return $this;
    }

    /**
     * Gibt die Mobilfunknummer des Nutzers
     * @return mixed
     */
    public function getTelefonMobil()
    {
        return $this->telefonMobil;
    }

    /**
     * @param mixed $telefonMobil
     * @return User
     */
    public function setTelefonMobil($telefonMobil)
    {
        $this->telefonMobil = $telefonMobil;
        return $this;
    }

    /**
     * Gibt die Private Festnetznummer des Nutzers
     * @return mixed
     */
    public function getTelefonPrivat()
    {
        return $this->telefonPrivat;
    }

    /**
     * @param mixed $telefonPrivat
     * @return User
     */
    public function setTelefonPrivat($telefonPrivat)
    {
        $this->telefonPrivat = $telefonPrivat;
        return $this;
    }

    /**
     * Gibt die Durchwahl des Nutzers
     * @return mixed
     */
    public function getTelefonDurchwahl()
    {
        return $this->telefonDurchwahl;
    }

    /**
     * @param mixed $telefonDurchwahl
     * @return User
     */
    public function setTelefonDurchwahl($telefonDurchwahl)
    {
        $this->telefonDurchwahl = $telefonDurchwahl;
        return $this;
    }

    /**
     * Gibt die Straße des Nutzers
     * @return mixed
     */
    public function getStrasse()
    {
        return $this->strasse;
    }

    /**
     * @param mixed $strasse
     */
    public function setStrasse($strasse)
    {
        $this->strasse = $strasse;
    }

    /**
     * Gibt den Ort des Nutzers
     * @return mixed
     */
    public function getOrt()
    {
        return $this->ort;
    }

    /**
     * @param mixed $ort
     */
    public function setOrt($ort)
    {
        $this->ort = $ort;
    }

    /**
     * Gibt die PLZ des Nutzers
     * @return mixed
     */
    public function getPlz()
    {
        return $this->plz;
    }

    /**
     * @param mixed $plz
     */
    public function setPlz($plz)
    {
        $this->plz = $plz;
    }

    /**
     * Gibt die Hausnummer des Nutzers
     * @return mixed
     */
    public function getHausnr()
    {
        return $this->hausnr;
    }

    /**
     * @param mixed $hausnr
     */
    public function setHausnr($hausnr)
    {
        $this->hausnr = $hausnr;
    }


    /**
     * Gibt den Nachnamen des Nutzers
     * @return mixed
     */
    public function getNachname()
    {
        return $this->nachname;
    }

    /**
     * @param mixed $nachname
     * @return User
     */
    public function setNachname($nachname)
    {
        $this->nachname = $nachname;
        return $this;
    }

    /**
     * Gibt die Mail-Adressen des Nutzers
     * @return array
     */
    public function getMailAdressen()
    {
        return $this->mailAdressen;
    }

    /**
     * @param array $mailAdressen
     */
    public function setMailAdressen($mailAdressen)
    {
        $this->mailAdressen = $mailAdressen;
    }

    /**
     * @return mixed
     */
    public function getLastLogin()
    {
        return $this->lastLogin;
    }

    public function getLastLoginISO8601() {
        return (new \DateTime($this->getLastLogin()))->format(\DateTime::ISO8601);
    }

    /**
     * @param mixed $lastLogin
     */
    public function setLastLogin($lastLogin)
    {
        $this->lastLogin = $lastLogin;
    }


    /**
     * Returns an array containing all information of this User object.
     * @return array
     */
    public function toArray() {
        return array(
            "id" => $this->getId(),
            "username" => $this->getUsername(),
            "vorname" => $this->getVorname(),
            "nachname" => $this->getNachname(),
            "strasse" => $this->getStrasse(),
            "hausnr" => $this->getHausnr(),
            "plz" => $this->getPlz(),
            "ort" => $this->getOrt(),
            "telefonDurchwahl" => $this->getTelefonDurchwahl(),
            "telefonPrivat" => $this->getTelefonPrivat(),
            "telefonMobil" => $this->getTelefonMobil(),
            "mailAdressen" => $this->getMailAdressen(),
            "lastLogin" => $this->getLastLogin()
        );

    }
}