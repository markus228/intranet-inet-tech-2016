<?php

/**
 * Created by PhpStorm.
 * User: markus
 * Date: 30.03.16
 * Time: 16:41
 */



class FixedPriorityQueue extends SplPriorityQueue {



    protected $max;

    public function __construct($max) {
        if ($max < 1) throw new Exception("Invalid Argument");
        parent::__construct();

        $this->max = $max;
    }

    public function insert($value, $priority) {
        if ($this->count() < $this->max) {
            parent::insert($value, $priority);
            return;
        }


        //Bis zum letzten Element vorspulen
        while ($this->valid()) {
            $this->next();
        }

        //Priorität des letzten Elements abrufen
        $this->setExtractFlags(SplPriorityQueue::EXTR_PRIORITY);
        $lastElementPrio = $this->current();





        parent::insert($value, $priority);
    }

}


class MiscTest extends PHPUnit_Framework_TestCase
{





    public function testfindNMostRecentlyChangedFiles() {
        $queue = new SplPriorityQueue();

        $queue->insert("aaa", 0);
        $queue->insert("zzzz", 10);
        $queue->insert("bbb", 5);


        foreach($queue as $el) {
            echo $el."\n";
        }



        foreach($queue as $el) {
            echo $el."\n";
        }

    }



    protected function setUp() {
        chdir("..");
    }

    public function testA() {


        $path = "./userfiles/markus";

        $objects = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($path));
        /**
         * @var $object SplFileInfo
         */
        foreach($objects as $name => $object){
            echo $object->getCTime();
            echo "$name\n";

        }


    }




}