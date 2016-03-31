<?php
/**
 * Created by PhpStorm.
 * User: markus
 * Date: 30.03.16
 * Time: 09:15
 */

namespace database;


use models\News;

class NewsDAO extends AbstractDAO
{


    public static $FIELD_NEWS_TABLE = array("id", "user_id", "datetime", "content");

    /**
     * @var UserDAO
     */
    private $userDAO;

    public function __construct(Database $database, UserDAO $userDAO) {
        parent::__construct($database);
        $this->userDAO = $userDAO;
    }

    /**
     * Ruft alle Neuigkeiten ab
     * @return News[]
     */
    public function getAllNews() {
        $resultSet = $this->database->fetchRowMany("SELECT * FROM news");
        return $this->newsSetParser($resultSet);
    }

    /**
     * Ruft alle Neuigkeiten nach ihrem Publikationszeitpinkt ab
     * @return \models\News[]
     */
    public function getAllNewsDescending() {
        $resultSet = $this->database->fetchRowMany("SELECT * FROM news ORDER BY datetime DESC");
        return $this->newsSetParser($resultSet);
    }

    /**
     * Ruft eine Nachricht an Hand ihrer ID ab
     * @param $id
     * @return News
     */
    public function getNewsById($id) {
        $result = $this->database->fetchRow("SELECT * FROM news WHERE id = :id", array("id" => $id));
        return $this->newsParser($result);
    }

    /**
     * Fügt eine Neuigkeit hinzu
     * @param News $news
     * @return News
     */
    public function addNews(News $news) {
        $id = $this->database->insert("news", array(
            "content" => $news->getContent(),
            "user_id" => $news->getUser()->getId(),
            "datetime" => $news->getDatetime()->format("Y-m-d H:i:s"),
            "content" => $news->getContent()
        ));
        $news->setId($id);
        return $news;
    }

    /**
     * Löscht eine Neuigkeit
     * @param News $news
     */
    public function deleteNews(News $news) {
        return $this->deleteNewsById($news->getId());
    }

    /**
     * Löscht eine Neuigkeit an Hand ihrer ID
     * @param $id
     */
    public function deleteNewsById($id) {
        $this->database->delete("news",
            array(
                "id" => $id
            )
        );
    }


    /**
     * Parser für Verarbeitung des ResultSets
     * @param array $resultSets
     * @return News[]
     */
    private function newsSetParser(array $resultSets) {
        $output = array();

        foreach($resultSets as $resultSet) {
            $output[] = $this->newsParser($resultSet);
        }

        return $output;
    }



    /**
     * Parser für Verarbeitung des ResultSets
     * @param $resultSet
     * @return News
     */
    private function newsParser($resultSet) {

        $userObject = $this->userDAO->getUserById($resultSet["user_id"]);
        $newsObject = new News($resultSet["id"], $userObject, new \DateTime($resultSet["datetime"]), $resultSet["content"]);

        return $newsObject;
    }



}