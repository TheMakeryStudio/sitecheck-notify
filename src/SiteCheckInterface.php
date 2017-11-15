<?php

namespace TheNavigators\SiteCheckNotify;

interface SiteCheckInterface
{
    /**
     * Set the recipient list.
     * @param array $urls
     */
    public function setRecipients(array $recipients);

    /**
     * Set the url list.
     * @param array $urls
     */
    public function setUrls(array $urls);

    /**
     * Run the library.
     * @return type
     */
    public function run();
}
