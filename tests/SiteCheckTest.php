<?php

use Orchestra\Testbench\TestCase;
use TheNavigators\SiteCheckNotify\SiteCheckProvider;

class SiteCheckTest extends TestCase
{
    public function getPackageProviders($app)
    {
        return [
            SiteCheckProvider::class,
        ];
    }

    public function setUp()
    {
        parent::setUp();
    }

    public function testArtisanCommand()
    {
        $this->assertTrue(false);
    }

    public function testItResolvesRepository()
    {
        $this->assertTrue(false);
    }

    public function testItSetsUrls()
    {
        $this->assertTrue(false);
    }

    public function testItDetects500Errors()
    {
        $this->assertTrue(false);
    }

    public function testItIgnores200Errors()
    {
        $this->assertTrue(false);
    }

    public function testItSetsRecipients()
    {
        $this->assertTrue(false);
    }

    public function testItCatchesHttpError()
    {
        $this->assertTrue(false);
    }

    public function testItNotifiesAllRecipients()
    {
        $this->assertTrue(false);
    }

    public function testItLogsNon200Requests()
    {
        $this->assertTrue(false);
    }

    public function testItSendsEmail()
    {
        $this->assertTrue(false);
    }
}
