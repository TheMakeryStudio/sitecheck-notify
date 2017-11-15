<?php

namespace TheNavigators\SiteCheckNotify;

use Exception;
use GuzzleHttp\Client as HttpClient;
use Illuminate\Contracts\Logging\Log;
use Illuminate\Contracts\Mail\Mailer;

class SiteCheckRepository implements SiteCheckInterface
{
    /**
     * @var string
     */
    protected $from;

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
     * Who the email message is from.
     * @param string $from 
     * @return type
     */
    public function setFrom($from='')
    {
        $this->from = $from;
        return $this;
    }

    /**
     * Set email recipients.
     * @param array $recipients
     * @return type
     */
    public function setRecipients($recipients=[])
    {
        $this->recipients = $recipients;
        return $this;
    }

    /**
     * Set the url list.
     * @param array $urls
     * @return type
     */
    public function setUrls($urls=[])
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
        if (empty($this->from)) {
            throw new Exception('You must add a from address to ' .
                'config/sitecheck.php');
        }

        if (empty($this->recipients) || empty($this->urls)) {
            throw new Exception('You need to add at least 1 url and 1 ' .
                'recipient to config/sitecheck.php.');
        }

        $is_valid = true;

        foreach ($this->urls as $url) {
            try {
                $res = $this->client->get($url);

                if ($res->getStatusCode() !== 200) {
                    $is_valid = false;
                }

            } catch (Exception $e) {

                $is_valid = false;

            } finally {
                
                if (! $is_valid) {
                    $this->notifyAll($url);
                    $this->logFailure($url);
                    $is_valid = true;
                }
            }
        }
        return $is_valid;
    }

    /**
     * Notify all users in the recipient list.
     * @return type
     */
    private function notifyAll(string $url)
    {
        $this->mailer->raw(trans('sitecheck::notify.body', [
            'url' => $url,
        ]), function ($message) {

            $message->subject(trans('sitecheck::notify.subject'))
                ->from($this->from)
                ->to($this->recipients);
        });
    }

    /**
     * Log the failed request;
     * @param type $url
     * @return type
     */
    private function logFailure($url)
    {
        $this->logger->error(trans('sitecheck::notify.log', [
            'url' => $url]));
    }
}
