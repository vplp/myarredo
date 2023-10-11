<?php

namespace common\components\YandexKassaAPI\interfaces;

use yii\db\ActiveRecordInterface;

/**
 * Interface OrderInterface
 *
 * @package common\components\YandexKassaAPI\interfaces
 */
interface OrderInterface extends ActiveRecordInterface
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
     * @return integer
     */
    public function getEmail();

    /**
     * @return integer
     */
    public function getItems();

    /**
     * @param $invoiceId
     * @return OrderInterface
     */
    public function findByInvoiceId($invoiceId);
}
