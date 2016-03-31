<?php
/**
 * Created by PhpStorm.
 * User: markus
 * Date: 16.01.16
 * Time: 15:47
 */

namespace core;


use database\AlertStack;
use database\Authenticator;
use database\Database;
use database\EmailAccountDAO;
use database\NewsDAO;
use database\UserDAO;
use models\EmailAccount;
use models\fileaccess\Access;

/**
 * Class ApplicationRoot
 * @package core
 *
 * Wurzel der Applikation
 * Enthält Instanzen der Datenbankzugriffschichten
 */
class ApplicationRoot
{


    /**
     * @var Authenticator
     */
    private $authenticator;
    /**
     * @var UserDAO
     */
    private $userDAO;

    /**
     * @var NewsDAO
     */
    private $newsDAO;


    /**
     * @var EmailAccountDAO
     */
    private $emailAccountDAO;

    /**
     * @var Database
     */
    private $database;

    /**
     * @var AlertStack
     */
    private $alertStack;



    public function __construct() {

    }


    /**
     * @return Authenticator
     */
    public function getAuthenticator()
    {
        if (!$this->authenticator instanceof Authenticator) {
            $this->authenticator = $this->getUserDAO();
        }
        return $this->authenticator;
    }


    /**
     * @return NewsDAO
     */
    public function getNewsDAO() {
        if (!$this->newsDAO instanceof NewsDAO) {
            $this->newsDAO = new NewsDAO($this->getDatabase(), $this->getUserDAO());
        }
        return $this->newsDAO;
    }

    /**
     * @return EmailAccountDAO
     */
    public function getEmailAccountDAO() {
        if (!$this->emailAccountDAO instanceof EmailAccountDAO) {
            $this->emailAccountDAO = new EmailAccountDAO($this->getDatabase(), $this->getUserDAO());
        }
        return $this->emailAccountDAO;
    }

    /**
     * @return UserDAO
     */
    public function getUserDAO()
    {
        if (!$this->userDAO instanceof UserDAO) {
            $this->userDAO = new UserDAO($this->getDatabase());
        }
        return $this->userDAO;
    }

    /**
     * @return Database
     */
    public function getDatabase()
    {
        if (!$this->database instanceof Database) {
            $this->database = new Database(Config::$DB_HOST, Config::$DB_USER, Config::$DB_PASSWORD, Config::$DB_DATABASE);
        }
        return $this->database;
    }


    /**
     * @return AlertStack
     */
    public function getAlertStack() {
        if (!$this->alertStack instanceof AlertStack) {
            $this->alertStack = new AlertStack();
        }
        return $this->alertStack;
    }







}