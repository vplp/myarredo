<?php

namespace common\components\YandexKassaAPI;

use yii\base\Component;
use YandexCheckout\Client;
use common\components\YandexKassaAPI\interfaces\PaymentInterface;

/**
 * Class YandexKassaAPI
 *
 * @package common\components\YandexKassaApi
 */
class YandexKassaAPI extends Component
{
    public $shopId;
    public $key;
    private $client;
    public $returnUrl;
    public $currency = "RUB";

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        $this->client = new Client();
        $this->client->setAuth($this->shopId, $this->key);
    }

    /**
     * @param PaymentInterface $order
     * @return mixed
     */
    public function createPayment(PaymentInterface $order)
    {
        $payment = $this->client->createPayment(
            array(
                'amount' => array(
                    'value' => $order->getPaymentAmount(),
                    'currency' => $this->currency
                ),
                'confirmation' => array(
                    'type' => 'redirect',
                    'return_url' => $this->returnUrl,
                ),
                'description' => 'Заказ №' . $order->id,
            ),
            $this->generateIdempotent()
        );

        $order->setInvoiceId($payment->getId());

        $order->save();

        return $payment;
    }

    /**
     * @param $invoiceId
     * @return mixed
     */
    public function getPayment($invoiceId)
    {
        return $this->client->getPaymentInfo($invoiceId);
    }

    /**
     * @param $invoiceId
     * @param PaymentInterface $order
     * @return bool
     */
    public function confirmPayment($invoiceId, PaymentInterface $order)
    {
        $payment = $this->getPayment($invoiceId);

        if ($payment->getPaid()) {
            $data = [
                'amount' => [
                    'value' => $order->getPaymentAmount(),
                    'currency' => 'RUB',
                ],
            ];

            $confirm = $this->client->capturePayment($data, $order->getInvoiceId(), $this->generateIdempotent());

            return $confirm;
        }

        return false;
    }

    /**
     * @return string
     */
    private function generateIdempotent()
    {
        return uniqid('', true);
    }
}
