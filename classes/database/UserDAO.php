<?php
/**
 * Created by PhpStorm.
 * User: markus
 * Date: 08.01.16
 * Time: 16:24
 */

namespace database;

use exceptions\IntranetDatabaseException;
use exceptions\UnauthorizedException;
use helpers\FilterHelper;
use models\User;

class UserDAO extends AbstractDAO implements Authenticator
{

    public static $FIELDS_FOR_USER_OBJECT = array ("id", "username", "vorname", "nachname", "strasse", "hausnr", "plz", "ort", "telefonDurchwahl", "telefonPrivat", "telefonMobil");

    public static function hashPassword($password) {
        return password_hash($password, PASSWORD_DEFAULT);
    }

    public static function verifyPasswordHash($password, $hash) {
        return password_verify($password, $hash);
    }


    /**
     * @var EmailDAO
     */
    private $emailDAO;


    public function __construct($database) {
        parent::__construct($database);
        $this->emailDAO = new EmailDAO($this->database);
    }

    /**
     * Gibt alle User zurück
     * @return User[]
     */
    public function getAllUsers() {
        $results = $this->database
            ->fetchRowMany("SELECT * FROM users WHERE 1");

        return $this->userSetParser($results);
    }

    /**
     * Holt Nutzer an Hand seines Nutzernamens
     * @param $username
     * @return User
     */
    public function getUserByUsername($username) {
        $result = $this->database
            ->fetchRow("SELECT * FROM users WHERE username = :username",
                array(
                    "username" => $username
                )
            );

        return $this->userParser($result);

    }

    /**
     * Holt Nutzer an Hand seiner ID
     * @param $id
     * @return null|User
     */
    public function getUserById($id) {
        $result = $this->database
            ->fetchRow("SELECT * FROM users WHERE id = :id",
                array(
                    "id" => $id
                )
            );

        return $this->userParser($result);
    }


    /**
     * Fügt Nutzer hinzu
     * @param User $user
     * @return User
     */
    public function addUser(User $user, $password) {
        $id = $this->database->insert("users", array(
            "username" => $user->getUsername(),
            "password_hash" => self::hashPassword($password),
            "vorname" => $user->getVorname(),
            "nachname" => $user->getNachname(),
            "strasse" => $user->getStrasse(),
            "hausnr" => $user->getHausnr(),
            "plz" => $user->getPlz(),
            "ort" => $user->getOrt(),
            "telefonDurchwahl" => $user->getTelefonDurchwahl(),
            "telefonPrivat" => $user->getTelefonPrivat(),
            "telefonMobil" => $user->getTelefonMobil(),
            "lastlogin" => "0000-00-00 00:00:00"
        ));


        $user->setId((int) $id);
        $this->emailDAO->addEmailAddressesForUser($user);

        return $user;

    }

    /**
     * Sucht Nutzer
     * @param $searchTerms
     * @return User[]
     */
    public function searchUser($searchTerms) {
        $searchTerms = "%".$searchTerms."%";
        $results = $this->database
            ->fetchRowMany(
                "SELECT * FROM users WHERE vorname LIKE :searchTerms OR nachname LIKE :searchTerms",
                array(
                    "searchTerms" => $searchTerms
                )
            );

        return $this->userSetParser($results);
    }

    /**
     * Bearbeitet Nutzer
     * @param User $user
     * @param null $password
     * @return User
     * @throws \Simplon\Mysql\MysqlException
     */
    public function editUser(User $user, $password = NULL) {

        $data = array(
            "username" => $user->getUsername(),
            "vorname" => $user->getVorname(),
            "nachname" => $user->getNachname(),
            "strasse" => $user->getStrasse(),
            "hausnr" => $user->getHausnr(),
            "plz" => $user->getPlz(),
            "ort" => $user->getOrt(),
            "telefonDurchwahl" => $user->getTelefonDurchwahl(),
            "telefonPrivat" => $user->getTelefonPrivat(),
            "telefonMobil" => $user->getTelefonMobil(),
            "lastLogin" => $user->getLastLogin()
        );
        //Method Overloading is a bitch in PHP... :/
        if (!is_null($password)) $data["password_hash"] = self::hashPassword($password);

        $this->database->update("users",
            array("id" => $user->getId()),
            $data
        );

        $this->emailDAO->editEMailAddressesForUser($user);


        return $user;
    }


    /**
     * Löscht Nutzer
     * @param User $user
     * @return bool
     */
    public function deleteUser(User $user) {
        $this->emailDAO->deleteEMailAddressesForUser($user);
        return $this->database->delete("users", array("username" => $user->getUsername()));
    }

    /**
     * @param $field
     * @param $array
     * @throws IntranetDatabaseException
     */
    private function assertFieldInArray($field, $array) {
        if (!array_key_exists("id", $array)) throw new IntranetDatabaseException("Feld: ".$field." nicht vorhanden!");
    }


    /**
     * @param array $resultSet
     * @return null|User
     * @throws IntranetDatabaseException
     */
    private function userParser(array $resultSet) {

        if (empty($resultSet)) return null;

        foreach (self::$FIELDS_FOR_USER_OBJECT as $field) {
            $this->assertFieldInArray($field, $resultSet);
        }

        $user =  new User(
            $resultSet["id"], $resultSet["username"], $resultSet["vorname"], $resultSet["nachname"], $resultSet["strasse"], $resultSet["hausnr"], $resultSet["plz"], $resultSet["ort"], $resultSet["telefonDurchwahl"], $resultSet["telefonPrivat"], $resultSet["telefonMobil"], array(), $resultSet["lastlogin"]
        );

        $emailAddresses = $this->emailDAO->getEMailAddressesForUser($user);
        $user->setMailAdressen($emailAddresses);

        return $user;

    }

    /**
     * Parser für ResultSet
     * @param array $resultSets
     * @return array
     */
    private function userSetParser(array $resultSets) {
        $output = array();

        foreach($resultSets as $resultSet) {
            $output[] = $this->userParser($resultSet);
        }

        return $output;
    }


    /**
     * Authentifiziert einen Nutzer
     * @param $user
     * @param $password
     * @throws UnauthorizedException
     */
    function authenticate($user, $password)
    {
        if (!$this->hasValidCredentials($user, $password)) throw new UnauthorizedException();
    }


    /**
     * Prüft ob Passwörter korrekt sind
     * @param $user
     * @param $password
     * @return bool
     */
    function hasValidCredentials($user, $password)
    {
        $this->refreshLastLogin($user);
        $hash = $this->database
            ->fetchColumn(
                "SELECT password_hash FROM users WHERE username = :username",
                array(
                    "username" => $user
                )
            );
        return self::verifyPasswordHash($password, $hash);
    }

    /**
     * Setzt lastlogin
     * @param $user
     * @throws \Simplon\Mysql\MysqlException
     */
    private function refreshLastLogin($user) {

        $user = FilterHelper::onlyAlphaNumeric($user);
        $this->database->executeSql("UPDATE users SET lastlogin = NOW() WHERE username = '".$user."'");

    }
}