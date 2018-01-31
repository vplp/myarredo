<?php

namespace common\components\sendpulse;

use yii\base\Component;

use Sendpulse\RestApi\ApiClient;
use Sendpulse\RestApi\Storage\FileStorage;

/**
 * Class SendPulse REST API
 *
 * @package common\components\sendpulse
 */
class SendPulse extends Component
{
    public $userId;
    public $secret;

    private $client;

    public function init()
    {
        $this->client = new ApiClient($this->userId, $this->secret);

        parent::init();
    }

    /**
     * Get list of address books
     *
     * @return mixed
     */
    public function listAddressBooks()
    {
        return $this->client->listAddressBooks();
    }

    /**
     * List all senders
     *
     * @return mixed
     */
    public function listSenders()
    {
        $requestResult = $this->client->listSenders();

        return $this->handleResult($requestResult);
    }

    /**
     * Add new emails to address book
     *
     * @param $bookId
     * @param $emails
     * @return mixed|stdClass
     */
    public function addEmails($bookId, $emails)
    {
        return $this->client->addEmails($bookId, $emails);
    }

    /**
     * List email addresses from book
     *
     * @param $id
     *
     * @return mixed|stdClass
     */
    public function getEmailsFromBook($id)
    {
        return $this->client->getEmailsFromBook($id);
    }

    /**
     * Remove email addresses from book
     *
     * @param $bookId
     * @param $emails
     *
     * @return mixed|stdClass
     */
    public function removeEmails($bookId, $emails)
    {
        return $this->client->removeEmails($bookId, $emails);
    }

    /**
     * Create new campaign
     *
     * @param $senderName
     * @param $senderEmail
     * @param $subject
     * @param $body
     * @param $bookId
     * @param string $name
     * @param string $attachments
     * @return mixed
     */
    public function createCampaign($senderName, $senderEmail, $subject, $body, $bookId, $name = '', $attachments = '')
    {
        return $this->client->createCampaign($senderName, $senderEmail, $subject, $body, $bookId, $name, $attachments);
    }
}