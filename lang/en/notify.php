<?php

return [
    'subject' => 'Site Health Check Notification',
    'body'    => 'This is a site health check notification reply. The cron has ' .
    'detected a problem for :url. A response other than 200 OK was ' .
    'returned. This could mean that your site is down. Please check :url.',
    'log'     => 'The url check for :url failed. Please investigate manually.',
];
