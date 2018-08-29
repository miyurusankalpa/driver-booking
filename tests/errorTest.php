<?php
// use the following namespace
use PHPUnit\Framework\TestCase;

// extend using TestCase instead PHPUnit_Framework_TestCase
class SampleTest extends TestCase {
	
	public function testMy()
    {
		include("./mysqli.php");
        $this->assertEquals("system", $user);
    }
	
	public function testHeader()
    {
		$test = include("./header.php");
		$this->assertEquals(true, $test);
    }
	
	public function testFooterr()
    {
		$test = include("./footer.php");
		$this->assertEquals(true, $test);
    }
}