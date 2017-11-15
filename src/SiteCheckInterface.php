<?php

namespace TheNavigators\SiteCheckNotify;

interface SiteCheckInterface
{
    /**
     * Who the email message is from.
     * @param string $from
     * @return type
     */
    public function setFrom($from='');

    /**
     * Set the recipient list.
     * @param array $urls
     */
    public function setRecipients($recipients=[]);

    /**
     * Set the url list.
     * @param array $urls
     */
    public function setUrls($urls=[]);

    /**
     * Run the library.
     * @return type
     */
    public function run();
}
