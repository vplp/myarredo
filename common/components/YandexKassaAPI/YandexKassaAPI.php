<?php

namespace common\components\YandexKassaAPI;

use yii\base\Component;
use YandexCheckout\Client;
use common\components\YandexKassaAPI\interfaces\OrderInterface;

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
     * @param OrderInterface $order
     * @return mixed
     */
    public function createPayment(OrderInterface $order)
    {
        $payment = $this->client->createPayment(
            [
                'amount' => [
                    'value' => $order->getPaymentAmount(),
                    'currency' => $this->currency
                ],
                'receipt' => [
                    'items' => $order->getItems(),
                    'email' => $order->getEmail(),
                ],
                'confirmation' => [
                    'type' => 'redirect',
                    'return_url' => $this->returnUrl,
                ],
                'description' => '№' . $order->id,
            ],
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
     * @param OrderInterface $order
     * @return bool
     */
    public function confirmPayment($invoiceId, OrderInterface $order)
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
