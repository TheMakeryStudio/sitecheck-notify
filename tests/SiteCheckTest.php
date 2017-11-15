<?php

use InterNations\Component\HttpMock\PHPUnit\HttpMockTrait;
use Orchestra\Testbench\TestCase;
use TheNavigators\SiteCheckNotify\SiteCheckInterface;
use TheNavigators\SiteCheckNotify\SiteCheckProvider;
use TheNavigators\SiteCheckNotify\SiteCheckRepository;

class SiteCheckTest extends TestCase
{
    use HttpMockTrait;

    /**
     * @var checker
     */
    protected $checker;

    /**
     * @var type
     */
    protected $from = 'noreply@test.com';

    /**
     * @var type
     */
    protected $recipients = [
        'jason.boissonneault@thenavigators.com.au',
    ];

    /**
     * @var type
     */
    protected $urls = [
        'http://localhost:8082/foo',
    ];

    /**
     * Description
     * @return type
     */
    public static function setUpBeforeClass()
    {
        static::setUpHttpMockBeforeClass('8082', 'localhost');
    }

    /**
     * Description
     * @return type
     */
    public static function tearDownAfterClass()
    {
        static::tearDownHttpMockAfterClass();
    }

    /**
     * Define environment setup.
     *
     * @param  \Illuminate\Foundation\Application  $app
     * @return void
     */
    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('sitecheck.from', $this->from);
        $app['config']->set('sitecheck.recipients', $this->recipients);
        $app['config']->set('sitecheck.urls', $this->urls);
        $this->checker = $app->make(SiteCheckInterface::class);
    }

    public function getPackageProviders($app)
    {
        return [
            SiteCheckProvider::class,
        ];
    }

    public function setUp()
    {
        $this->setUpHttpMock();
        parent::setUp();
    }

    public function tearDown()
    {
        $this->tearDownHttpMock();
        parent::tearDown();
    }

    public function testItResolvesRepository()
    {
        $this->assertInstanceOf(SiteCheckRepository::class, $this->checker);
    }

    public function testItLoadsConfig()
    {
        $this->assertSame(config('sitecheck.from'), $this->from);
        $this->assertSame(config('sitecheck.recipients'), $this->recipients);
        $this->assertSame(config('sitecheck.urls'), $this->urls);
    }

    public function testItLoadsTranslations()
    {
        $this->assertSame(
            trans('sitecheck::notify.subject'),
            'Site Health Check Notification'
        );
    }

    public function testItDetects500Errors()
    {
        $mock = $this->http->mock
            ->when()
            ->methodIs('GET')
            ->pathIs('/foo')
            ->then()
            ->statusCode(500)
            ->end();

        $this->http->setUp();
        $this->assertFalse($this->checker->run());
    }

    public function testItIgnores200Errors()
    {
        $this->http->mock
            ->when()
            ->methodIs('GET')
            ->pathIs('/foo')
            ->then()
            ->statusCode(200)
            ->end();
        $this->http->setUp();
        $this->assertTrue($this->checker->run());
    }
}
