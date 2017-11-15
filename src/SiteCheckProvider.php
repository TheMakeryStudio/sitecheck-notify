<?php

namespace TheNavigators\SiteCheckNotify;

use GuzzleHttp\Client as HttpClient;
use Illuminate\Contracts\Mail\Mailer;
use Illuminate\Contracts\Logging\Log;
use Illuminate\Support\ServiceProvider;

class SiteCheckProvider extends ServiceProvider
{

    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        $root = __DIR__ . '/..';

        //$this->loadTranslationsFrom("$root/lang", 'sitecheck');

        //$this->loadViewsFrom("$root/views", 'sitecheck');

        $this->publishes([
            "$root/config/sitecheck.php" => config_path('sitecheck.php'),
        ], 'config');
    }

    /**
     * When requesting the SiteCheckInterface, return an instance of
     * The SiteCheckRepository and pass configs.
     *
     * @return SiteCheckRepository
     */
    public function register()
    {
        $this->app->bind(SiteCheckInterface::class, function ($app) {
            $site_check = new SiteCheckRepository(
                new HttpClient,
                $app->make(Mailer::class),
                $app->make(Log::class)
            );
            $site_check->setRecipients(config('sitecheck.recipients'))
                ->setUrls(config('sitecheck.urls'));

            return $site_check;
        });
    }
}
