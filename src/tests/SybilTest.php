<?php

require_once 'src/bootstrap.php';

use PHPUnit\Framework\TestCase;
use \HelloWorld\HelloWorld;

class SybilTest extends TestCase
{

    public function testConcatenateStrings()
    {
        $testRun = new HelloWorld();
        $str1 = 'hello';
        $str2 = 'world';
        $expectedResult = 'helloworld';

        $result = $testRun->concatenateStrings($str1, $str2);

        $this->assertEquals($expectedResult, $result);
    }

}