<?php

/**
 * Created by PhpStorm.
 * User: markus
 * Date: 19.03.16
 * Time: 18:38
 */
class FilesRowsViewTest extends PHPUnit_Framework_TestCase
{

    protected $view;


    protected function setUp() {

        chdir("..");
        $this->view = new \view\FilesRowsView();
        $this->view->setSize(123);
        $this->view->setIcon("blah");
        $this->view->setName("name");
        $this->view->setLink("link");
        $this->view->setLastChangeHumanReadable("12344");

    }


    public function testArray() {

        echo $this->view->toArray();


    }


}