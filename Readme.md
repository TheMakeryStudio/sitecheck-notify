# Site Check Notify

A Laravel package for sending an email to a list when a url endpoint is down
and logging any response that doesn't return 200 OK.

## Getting Started

Add the following git repository to composer.json:

```
    "repositories": [
        {
            "type": "vcs",
            "url": "https://github.com/TheMakeryStudio/sitecheck-notify"
        }
    ],
```

And then add the dependency:

```
    "require": {
        "php": ">=5.5.9",
        "laravel/framework": "5.2.*",
        "thenavigators/sitecheck-notify": "dev-master"
    },
```


### Prerequisites

The only dependency should be Laravel 5+.


### Installing

If not using autodetection in later Laravel versions, you will need to add
the service provider to your app config (config/app.php):

```
    TheNavigators\SiteCheckNotify\SiteCheckProvider::class,

```

Then publish to configuration file (config/sitecheck.php):

```
php artisan vendor:publish

```

Read the comments in the config file for an explanation of settings.

Once configured, you can run a site check as an artisan command:

``` 
php artisan check:site

```

### Scheduled Site checks

If you want to automate site checking, add as a scheduled console job in Kernel.php:


```
class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [

        TheNavigators\SiteCheckNotify\CheckSiteCommand::class,
    ];

    protected function schedule(Schedule $schedule)
    {
        $schedule->command('check:site')->hourly();
```

In the example above, the check:site command will run every hour. If any endpoint
in the config files returns anything other than a 200 resonse, an email will
notify everyone listed in the recipient list and the error will be logged 
by the Laravel logger. 

## Authors

* **Jason Boissonneault** - *Initial work* - [The Navigators](http://thenavigators.com.au)

## License

This project is licensed under the MIT License 
