<?php
/**
 * Created by PhpStorm.
 * User: markus
 * Date: 30.03.16
 * Time: 15:23
 */

namespace database;


use models\EmailAccount;
use models\User;

/**
 * Class EmailAccountDAO
 * @package database
 *
 * Zugriffsklasse für die EMail-Konto Daten
 */
class EmailAccountDAO extends AbstractDAO
{


    /**
     * @var UserDAO
     */
    private $userDAO;

    /**
     * @param Database $database
     * @param UserDAO $userDAO
     */
    public function __construct(Database $database, UserDAO $userDAO) {
        parent::__construct($database);
        $this->userDAO = $userDAO;
    }


    /**
     * Gibt zu einem User das zugehörige Email-Konto aus.
     * @param User $user
     * @return EmailAccount
     */
    public function getEmailAccountOfUser(User $user) {
        $resultSet = $this->database->fetchRow(
            "SELECT * FROM email_account WHERE user_id = :user_id",
            array("user_id" => $user->getId())
        );

        return $this->emailAccountParser($resultSet);

    }


    /**
     * Bearbeitet ein EMail-Konto
     * @param EmailAccount $emailAccount
     * @return EmailAccount
     */
    public function editEmailAccount(EmailAccount $emailAccount) {

        $data = array(

            "id" => $emailAccount->getId(),
            "user_id" => $emailAccount->getUser()->getId(),
            "aktiv" => $emailAccount->isAktiv(),
            "autores_from" => $emailAccount->getAutoresFrom(),
            "autores_fromname" => $emailAccount->getAutoresFromname(),
            "autores_singlesend" => $emailAccount->isAutoresSinglesend(),
            "autores_spamlevel" => $emailAccount->getAutoresSpamlevel(),
            "autores_subject" => $emailAccount->getAutoresSubject(),
            "autores_text" => $emailAccount->getAutoresText(),
            "storage_percent" => $emailAccount->getStoragePercent()
        );

        $this->database->update(
                "email_account",
                array(
                    "id" => $emailAccount->getId()
                ),
                $data
            );

        return $emailAccount;
    }



    /**
     * @param array $resultSets
     * @return EmailAccount[]
     */
    private function emailAccountSetParser(array $resultSets) {
        $output = array();

        foreach($resultSets as $resultSet) {
            $output[] = $this->emailAccountParser($resultSet);
        }

        return $output;
    }



    /**
     * @param $resultSet
     * @return News
     */
    private function emailAccountParser($resultSet) {
        $newsObject = new EmailAccount(

            $resultSet["id"], $this->userDAO->getUserById($resultSet["user_id"]), $resultSet["aktiv"], $resultSet["autores_from"], $resultSet["autores_fromname"], $resultSet["autores_singlesend"], $resultSet["autores_spamlevel"], $resultSet["autores_subject"], $resultSet["autores_text"], $resultSet["storage_percent"]

        );

        return $newsObject;
    }



}