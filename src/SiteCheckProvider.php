<?php

namespace TheNavigators\SiteCheckNotify;

use GuzzleHttp\Client as HttpClient;

class SiteCheckProvider
{

    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        $root = __DIR__ . '/..';

        $this->loadTranslationsFrom("$root/lang", 'sitecheck');

        $this->loadViewsFrom("$root/views", 'sitecheck');

        $this->publishes([
            "$root/config/sitecheck.php" => config_path('sitecheck.php'),
            "$root/config/sitecheck.php" => config_path('sitecheck.php'),
        ]);
    }

    /**
     * Description
     * @return type
     */
    public function register()
    {
        $urls       = config('sitecheck.urls');
        $recipients = config('sitecheck.recipients');

        $site_check = new SiteCheckRepository(new HttpClient);
        $site_check->setRecipients($recipients)->setUrls($urls);
    }
}
