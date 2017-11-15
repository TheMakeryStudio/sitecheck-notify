<?php

namespace TheNavigators\SiteCheckNotify;

interface SiteCheckInterface
{
    /**
     * Who the email message is from.
     * @param string $from
     * @return type
     */
    public function setFrom(string $from);

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
