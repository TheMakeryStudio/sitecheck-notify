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
     * @var logger
     */
    protected $logger;    

    /**
     * Create a new instance of the Site Check repository.
     * @param HttpClient $client
     * @return type
     */
    public function __construct(HttpClient $client, Mailer $mailer, Log $logger)
    {
        $this->client = $client;
        $this->mailer = $mailer;
        $this->logger = $logger;
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
        if (empty($this->recipients) || empty($this->urls)) {
            throw new Exception('You need to add at least 1 url and 1 ' .
                'recipient to config/sitecheck.php.');
        }

        $exception = false;

        foreach ($this->urls as $url) {
            try {
                $res = $this->client->get($url);
            } catch (Exception $e) {
                //dd($e);
                $exception = true;
            } finally {
                if ($res->getStatusCode() !== 200 || $exception) {
                    $this->notifyAll($url);
                    $this->logFailure($url);
                }
            }
        }
    }

    /**
     * Notify all users in the recipient list.
     * @return type
     */
    private function notifyAll(string $url)
    {
        $this->mailer->raw(__('sitecheck::body', [
            'url' => $url]
        ))
            ->subject(__('sitecheck::subject'))
            ->to($this->recipients);
    }

    /**
     * Log the failed request;
     * @param type $url
     * @return type
     */
    private function logFailure($url)
    {
        $this->logger(__('sitecheck::log', [
            'url' => $url]));
    }
}
