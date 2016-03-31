<?php
/**
 * Created by PhpStorm.
 * User: markus
 * Date: 15.03.16
 * Time: 11:50
 */

namespace database;


use models\User;


class EmailDAO extends AbstractDAO
{

    public function getEMailAddressesForUser(User $user) {
        $results = $this->database
            ->fetchRowMany("SELECT mail_address FROM email WHERE user_id = :user_id",
                array("user_id" => $user->getId())
            );

        $out = array();

        foreach ($results as $res) {
            $out[] = $res["mail_address"];
        }

        return $out;
    }

    /**
     * Bearbeitet EmailAdressen für einen Nutzer
     * @param User $user
     * @throws \Exception
     */
    public function editEMailAddressesForUser(User $user) {

        $this->database->beginTransaction();
        try {
            $data = array();

            foreach ($user->getMailAdressen() as $adr) {
                $data[] = array(
                    "mail_address" => $adr,
                    "user_id" => $user->getId()
                );
            }

            //Alle Löschen
            $this->database->delete("email", array("user_id" => $user->getId()));


            //Alle einfügen
            $this->database->insertMany("email",
                $data
            );

            $this->database->commit();
        } catch (\Exception $e) {
            $this->database->rollBack();
            throw $e;
        }


    }

    /**
     * Löscht EMailAdressen eines Nutzers
     * @param User $user
     */
    public function deleteEMailAddressesForUser(User $user) {
        $this->database->delete("email", array("user_id" => $user->getId()));
    }

    public function addEmailAddressesForUser(User $user) {
        $data = array();

        foreach ($user->getMailAdressen() as $adr) {
            $data[] = array(
                "user_id" => $user->getId(),
                "mail_address" => $adr
            );
        }

        return $this->database->insertMany("email",
            $data
        );
    }


}