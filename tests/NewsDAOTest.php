<?php
use database\Database;
use database\NewsDAO;
use database\UserDAO;
use models\News;
use models\User;

/**
 * Created by PhpStorm.
 * User: markus
 * Date: 30.03.16
 * Time: 09:39
 */
class NewsDAOTest extends PHPUnit_Framework_TestCase
{



    protected $database;
    /**
     * @var UserDAO
     */
    protected $userDAO;
    /**
     * @var NewsDAO
     */
    protected $newsDAO;

    protected function setUp() {
        $this->database = new Database("127.0.0.1", "root", "root", "intranet");
        $this->userDAO = new UserDAO($this->database);
        $this->newsDAO = new NewsDAO($this->database, $this->userDAO);
        $this->database->beginTransaction();
    }

    private function insertTestUsers() {

    }

    public function testGetAll() {
        $this->insertTestUsers();
        $res = $this->newsDAO->getAllNews();

        var_dump($res);
    }


    public function testArray() {
        $user = $this->userDAO->addUser(new User(null, "testUser2", "Markus", "Jungbluth", "Teststr.", "4", "66133", "Saarbrücken", "000", "000", "000", array("testUser1@test.de"), ''), "test");
        $news = new News(null, $user, new DateTime(), "blah blah blah");

        var_dump($news->toArray());
    }

    public function testInsert() {
        $user = $this->userDAO->addUser(new User(null, "testUser1", "Markus", "Jungbluth", "Teststr.", "4", "66133", "Saarbrücken", "000", "000", "000", array("testUser1@test.de"), ''), "test");
        $news = new News(null, $user, new DateTime(), "blah blah blah");
        $expected = $this->newsDAO->addNews($news);

        $value = $this->newsDAO->getNewsById($expected->getId());

        $this->assertEquals($expected, $value);


    }

    protected function tearDown() {
        $this->database->rollBack();
    }


}