<?php
declare(strict_types=1);

namespace App\Test\TestCase\SetupCase;

use Cake\Core\Configure;
use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;

class SetupCaseBaselineTest extends TestCase
{
    use IntegrationTestTrait;

    private array $serverBackup = [];

    protected function setUp(): void
    {
        parent::setUp();

        foreach (['SERVER_NAME', 'HTTP_HOST', 'SERVER_PORT', 'REQUEST_URI'] as $key) {
            $this->serverBackup[$key] = $_SERVER[$key] ?? null;
        }

        $_SERVER['SERVER_NAME'] = 'localhost';
        $_SERVER['HTTP_HOST'] = 'localhost';
        $_SERVER['SERVER_PORT'] = '80';
        $_SERVER['REQUEST_URI'] = '/';

        $this->session(['TempAccessGiven' => 'TRUE']);
    }

    protected function tearDown(): void
    {
        foreach ($this->serverBackup as $key => $value) {
            if ($value === null) {
                unset($_SERVER[$key]);
                continue;
            }

            $_SERVER[$key] = $value;
        }

        parent::tearDown();
    }

    public function testPagesHomeRedirectsToDefaultLanguage(): void
    {
        Configure::write('debug', true);

        $this->get('/pages/home');

        $this->assertRedirectContains('/en/pages/home');
    }

    public function testLoginPageRendersSuccessfully(): void
    {
        Configure::write('debug', true);

        $this->get('/en/login');

        $this->assertResponseOk();
        $this->assertResponseContains('<h3>Login</h3>');
        $this->assertResponseContains('Please enter your username and password');
    }
}
