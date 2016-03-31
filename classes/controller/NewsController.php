<?php
/**
 * Created by PhpStorm.
 * User: markus
 * Date: 30.03.16
 * Time: 12:19
 */

namespace controller;


use models\News;

/**
 * Class NewsController
 * @package controller
 * Controller für den Zugriff auf die News
 */
class NewsController extends Controller
{


    /**
     * Holt alle Nachrichten
     * @return string
     * @AuthRequired
     */
    public function getNewsAction() {
        $news = $this->router->getApplicationRoot()->getNewsDAO();
        $user = $this->router->getApplicationSession()->getUser();

        $outArr = array();

        foreach($news->getAllNewsDescending() as $newsEl) {
            $outArr[] = $newsEl->toArray();
        }


        return json_encode(array(
            "currUser" => $user->toArray(),
            "data" => $outArr
        ));

    }

    /**
     * Erstellt eine neue Nachricht
     * @throws \exceptions\UnauthorizedException
     */
    public function postAction() {
        $news = $this->router->getApplicationRoot()->getNewsDAO();
        $user = $this->router->getApplicationSession()->getUser();
        $content = $this->router->getRequestAnalyzer()->getPostRequest()["data"];


        $newsObject = new News(null, $user, new \DateTime(), $content);

        $news->addNews($newsObject);

    }

    /**
     * Löscht eine Nachricht
     * @throws \Exception
     * @throws \exceptions\UnauthorizedException
     */
    public function deleteAction() {
        $news = $this->router->getApplicationRoot()->getNewsDAO();
        $user = $this->router->getApplicationSession()->getUser();
        $id = $this->router->getRequestAnalyzer()->getPostRequest()["id"];

        $userNews = $news->getNewsById($id)->getUser();
        if ($user->getId() != $userNews->getId()) throw new \Exception("Not authorized!");

        $news->deleteNewsById($id);
    }


    public function defaultAction()
    {

    }

    public function unsupportedAction()
    {

    }
}