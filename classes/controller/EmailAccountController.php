<?php
/**
 * Created by PhpStorm.
 * User: markus
 * Date: 30.03.16
 * Time: 15:41
 */

namespace controller;


use models\EmailAccount;

/**
 * Class EmailAccountController
 * @package controller
 *
 * Controller für die Manipulation der EMail-Konten Datensatzes
 */
class EmailAccountController extends Controller
{


    /**
     * Ruft Informationen zu Email-Konto ab
     * @return string
     * @throws \exceptions\UnauthorizedException
     * @AuthRequired
     */
    public function getAction() {
        $user = $this->router->getApplicationSession()->getUser();
        $emailAccountDAO = $this->router->getApplicationRoot()->getEmailAccountDAO();

        $account = $emailAccountDAO->getEmailAccountOfUser($user);


        return json_encode(
            array(
                "data" => $account->toArray()
            )
        );
    }


    /**
     * Ändert Informationen von EMail-Konto
     */
    public function postAction() {
        $user = $this->router->getApplicationSession()->getUser();
        $emailAccountDAO = $this->router->getApplicationRoot()->getEmailAccountDAO();

        //Daten von Client abrufen
        $postData = $this->router->getRequestAnalyzer()->getPostRequest();
        //Bisherige Daten aus DB abrufen
        $account = $emailAccountDAO->getEmailAccountOfUser($user);


        $account->setAktiv($postData["aktiv"]);
        $account->setAutoresFrom($postData["from"]);
        $account->setAutoresFromname($postData["fromname"]);
        $account->setAutoresSinglesend($postData["singlesend"]);
        $account->setAutoresSubject($postData["subject"]);
        $account->setAutoresText($postData["text"]);

        $emailAccountDAO->editEmailAccount($account);

    }


    public function defaultAction()
    {

    }

    public function unsupportedAction()
    {

    }
}