<?php
declare(strict_types=1);

namespace App\Test\TestCase\SetupCase;

use Cake\TestSuite\TestCase;

class SetupCaseBaselineTest extends TestCase
{
    public function testSetupCaseBaseline(): void
    {
        $this->assertEquals(1,1);
        //$this->fail('CI not configured yet');
    }
}
