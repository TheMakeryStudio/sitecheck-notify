<?php

namespace TheNavigators\SiteCheckNotify;

use Illuminate\Console\Command;
use TheNavigators\SiteCheckNotify\SiteCheckInterface as SiteCheck;

class CheckSiteCommand extends Command
{
    /**
     * @var SiteCheck
     */
    protected $site_check;

    /**
     * @var array
     */
    protected $recipients;

    /**
     * @var array
     */
    protected $urls;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'check:site';

    /**
     * Create an instacnce of the command and
     * pass in an HTTP client.
     * @return type
     */
    public function __construct(SiteCheck $site_check)
    {
        $this->site_check = $site_check;
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->site_check->run();
    }
}
