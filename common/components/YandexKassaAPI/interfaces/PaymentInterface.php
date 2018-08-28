<?php

namespace common\components\YandexKassaAPI\interfaces;

use yii\db\ActiveRecordInterface;

/**
 * Interface PaymentInterface
 *
 * @package common\components\YandexKassaAPI\interfaces
 */
interface PaymentInterface extends ActiveRecordInterface
{
    /**
     * @param $invoiceId string
     */
    public function setInvoiceId($invoiceId);

    /**
     * @return string
     */
    public function getInvoiceId();

    /**
     * @return integer
     */
    public function getPaymentAmount();

    /**
     * @param $invoiceId
     * @return PaymentInterface
     */
    public function findByInvoiceId($invoiceId);
}