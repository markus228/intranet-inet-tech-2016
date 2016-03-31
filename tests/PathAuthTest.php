<?php

use models\PathAuth;
use models\User;

class PathAuthTest extends PHPUnit_Framework_TestCase
{


    /**
     * @var PathAuth
     */
    private $pathAuth;

    protected function setUp() {
        chdir("..");
        $this->pathAuth = new PathAuth(new User(null, "testUser1", "Markus", "Jungbluth", "Teststr.", "4", "66133", "Saarbrücken", "000", "000", "000", array("testUser1@test.de")));
    }

    /**
     * @expectedException Exception
     */
    public function testNonExistingPath1() {
        $this->pathAuth->isPathValid("/etc/abc");
    }

    /**
     * @expectedException Exception
     */
    public function testNonExistingPath2() {
        $this->pathAuth->isPathValid("./userfiles/yolo");

    }

    public function testExistingPath() {
        $this->assertTrue($this->pathAuth->isPathValid("./userfiles/testUser1/a"));
    }

    public function testExistingIllegalPath() {
        $this->assertFalse($this->pathAuth->isPathValid("../../../../../../../../../../tmp/"));
    }

    public function testDoubleDotConversion1() {
        $path = "./userfiles/markus/a/b/c/..";
        $out =  PathAuth::resolveDoubleDotPath($path);
        $this->assertEquals("./userfiles/markus/a/b", $out);
    }

    public function testDoubleDotConversion2() {
        $path = "./userfiles/markus/a/b/c/../";
        $out =  PathAuth::resolveDoubleDotPath($path);
        $this->assertEquals("./userfiles/markus/a/b", $out);
    }

    public function testDoubleDotConversion3() {
        $path = "./userfiles/markus/a/b/c/../..";
        $out =  PathAuth::resolveDoubleDotPath($path);
        $this->assertEquals("./userfiles/markus/a", $out);
    }

    public function testSplitPath() {
        $path = "./userfiles/markus/a/b/c";
        $out = PathAuth::splitPath($path);

        var_dump($out);

        if (count($out) != 6) $this->fail("Invalid amount of parts");

        $this->assertEquals(".", $out["."]);
        $this->assertEquals($path, $out["c"]);
        $this->assertEquals("./userfiles", $out["userfiles"]);

    }

    public function testBasePath() {
        $path = "./userfiles/markus/a/b/test.txt";

        PathAuth::getBasePath($path);



    }


}