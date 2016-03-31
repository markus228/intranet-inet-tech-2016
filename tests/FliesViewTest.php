<?php
use models\FileShare;
use models\PathAuth;

/**
 * Created by PhpStorm.
 * User: markus
 * Date: 19.03.16
 * Time: 19:01
 */
class FliesViewTest extends PHPUnit_Framework_TestCase
{
    protected $view;


    protected function setUp()
    {

        chdir("..");
        $fileShare = new FileShare(new PathAuth(new \models\User(null, null, null, null, null, null, null, null, null, null, null, array())), ".");
        $this->view = new \view\FilesView();

    }


    public function testArray()
    {

        var_dump($this->view->toArray());

    }

}