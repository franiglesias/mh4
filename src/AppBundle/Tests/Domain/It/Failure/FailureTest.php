<?php

namespace AppBundle\Tests\Domain\It\Failure;

use AppBundle\Domain\It\Failure\Failure;

/**
* Description
*/
class FailureTest extends \PHPUnit_Framework_Testcase
{
	public function testFailureHasADescription()
	{
		$Failure = new Failure('Description');
		$this->assertAttributeEquals('Description', 'description', $Failure);
		return $Failure;
	}
	/**
	 * @depends testFailureHasADescription
	 *
	 * @param Failure $Failure 
	 */
	public function testFAilureAutomaticallySetsAReportedDate(Failure $Failure)
	{
		$this->assertAttributeEquals(new \DateTimeImmutable(), 'reported', $Failure);
	}
}

?>