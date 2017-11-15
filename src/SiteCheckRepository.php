<?php

namespace TheNavigators\SiteCheckNotify;

use GuzzleHttp\Client as HttpClient;
use Illuminate\Contracts\Mail\Mailer;

class SiteCheckRepository implements SiteCheckInterface
{
    /**
     * @var array
     */
    protected $recipients;

    /**
     * @var array
     */
    protected $urls;

    /**
     * @var http client
     */
    protected $client;

    /**
     * @var mailer
     */
    protected $mailer;

    /**
     * Create a new instance of the Site Check repository.
     * @param HttpClient $client 
     * @return type
     */
    public function __construct(HttpClient $client, Mailer $mailer)
    {
        $this->client = $client;
        $this->mailer = $mailer;
    }

    /**
     * Set email recipients.
     * @param array $recipients 
     * @return type
     */
    public function setRecipients(array $recipients)
    {
        $this->recipients = $recipients;
        return $this;
    }

    /**
     * Set the url list.
     * @param array $urls 
     * @return type
     */
    public function setUrls(array $urls)
    {
        $this->urls = $urls;
        return $this;
    }

    /**
     * Check each url in the urls list.
     * @return type
     */
    public function run()
    {
        foreach ($this->urls as $url) {
            $res = $this->client->get($url);
            if ($res->getStatusCode() !== 200) {
                $this->notifyAll($url);
                $this->logFailure($url);
            }
        }
    }

    /**
     * Notify all users in the recipient list.
     * @return type
     */
    private function notifyAll(string $url)
    {
        $this->mailer->to($this->recipients)
            ->subject(__('sitecheck::subject'))
            ->send(new SiteCheckFailure($url));
    }

    /**
     * Log the failed request;
     * @param type $url 
     * @return type
     */
    private function logFailure($url)
    {
        
    }
}
