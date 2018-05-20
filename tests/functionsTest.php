<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;

final class FunctionsTest extends TestCase
{
    public function testCanUserNameBeRead(): void
    {
        $this->assertNotFalse(
            LoginUser::class,
            LoginUser::execute(),
			LoginUser::$fehler
        );
    }
}
?>