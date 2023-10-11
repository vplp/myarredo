<?php

namespace common\components\sendpulse;

use yii\base\Component;

use Sendpulse\RestApi\ApiClient;
use Sendpulse\RestApi\Storage\FileStorage;
use common\modules\books\models\Books;

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

    private static $smtp_pz_secret = 'F3PV9g2SMuFgBePQMc5Eyt5WozzFv9O12uL1';

    public function init()
    {
        $this->client = new ApiClient($this->userId, $this->secret, new FileStorage(sys_get_temp_dir()));

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
        return Books::addEmails($bookId, $emails);;
        //return $this->client->addEmails($bookId, $emails);
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
        return  Books::getCampaign($id);
        //return $this->client->getEmailsFromBook($id);
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
        return Books::removeEmails($bookId, $emails);
        //return $this->client->removeEmails($bookId, $emails);
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
    public function createCampaign($senderName, $senderEmail, $subject, $body, $bookId, $name = '', $attachments = '', $modelOrder = false)
    {
        //return $this->client->createCampaign($senderName, $senderEmail, $subject, $body, $bookId, $name, $attachments);
        return $this->sendSmtpBz($senderName, $senderEmail, $subject, $body, $bookId, $name, $attachments, $modelOrder);
    }

    public function sendSmtpBz($senderName, $senderEmail, $subject, $body, $bookId, $name = '', $attachments = '', $modelOrder = false) {
        if (!self::chekStmpBzLimits()) return "Have no limits!";
        $book = Books::getCampaign($bookId);
        $arFactories = array();
        if ($modelOrder) {
            foreach ($modelOrder->items as $item) {
                $arFactories[] = $item->product->factory_id;
            }
        }
        $arEmails = array();
        foreach ($book as $mail) {
            if (!empty($arFactories)) {
                $user = User::findBase()
                    ->andWhere([
                        'email' => $mail->email
                    ])
                    ->one();
                if (empty($user) || empty($user->profile) || empty($user->profile->factories)) continue;
                if(!in_array($user->profile->country_id, [1,2,3])) {
                    $arUserFactories = array();
                    foreach($user->profile->factories as $factory){
                       $arUserFactories[] = $factory->id;
                    }
                    if (empty(array_intersect($arFactories,$arUserFactories))) continue;
                }
            }
            $arEmails[$mail->email] = $mail->name;
        }
        if (!empty($arEmails)){
           return \Yii::$app->mailer
                            ->compose()
                            ->setFrom([$senderEmail => $senderName])
                            ->setBcc($arEmails)
                            ->setSubject($subject)
                            ->setHtmlBody($body)
                            ->send();
        }
        return  array('is_error' => true, 'message' => 'Empty emails for bookId='.$bookId);
    }

    private static function chekStmpBzLimits() {
        $curl = curl_init();
        curl_setopt_array($curl, array(
          CURLOPT_URL => "https://api.smtp.bz/v1/user",
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_TIMEOUT => 30,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => "GET",
          CURLOPT_HTTPHEADER => array(
            "authorization: ".self::$smtp_pz_secret
          ),
        ));

        $response = curl_exec($curl);
        curl_close($curl);

        $result = json_decode($response, 1);

        return ($result["hlimit"] - $result["hsent"] > 10) && ($result["dlimit"] - $result["dsent"] > 10);
    }
}