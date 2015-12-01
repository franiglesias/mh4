<?php

namespace AppBundle\Domain\It\Failure;

/**
* Describes a Failure
*/
class Failure
{
	private $description;
	private $reported;
	
	function __construct($description)
	{
		$this->description = $description;
		$this->reported = new \DateTimeImmutable();
	}
}

?>