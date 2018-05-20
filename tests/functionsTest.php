<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;

class FunctionsTest extends TestCase
{
	
	public function testCanRightUserNameBeAccepted(): void
    {
		$LoginUser = new LoginUser('mwintersperger', '123Fiona');
		$LoginUser->execute();
		$this->assertNotFalse(
			$LoginUser->$fehler
        );
    }
	
	public function testCanWrongUsernameBeBlocked(): void
    {
		$LoginUser = new LoginUser('wrong', '123Fiona');
		$LoginUser->execute();
		$this->assertFalse(
			$LoginUser->$fehler
        );
    }
}
?>