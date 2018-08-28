<?php

namespace common\components\YandexKassaAPI\actions;

use yii\base\Action;
use yii\web\HttpException;
//
use common\components\YandexKassaAPI\YandexKassaAPI;
use common\components\YandexKassaAPI\interfaces\PaymentInterface;

/**
 * Class CreatePaymentAction
 *
 * @package mikefinch\YandexKassaAPI\actions
 * @author Andrii Bondarchuk <zndron@gmail.com>
 */
class CreatePaymentAction extends Action
{
    /**
     * Выполняется перед платежом.
     * @var callable
     */
    public $beforePayment;

    public $componentName = "yandexKassa";

    /**
     * @var string
     */
    public $orderClass;

    /**
     * @param $id
     * @return \yii\web\Response
     * @throws HttpException
     * @throws \yii\base\InvalidConfigException
     */
    public function run($id)
    {
        $orderModel = \Yii::createObject($this->orderClass);

        if (!$orderModel instanceof PaymentInterface) {
            throw new HttpException(500, "Модель должна реализовывать интерфейс PaymentInterface");
        }

        $order = $orderModel::findOne($id);

        if ($this->beforePayment && !call_user_func($this->beforePayment, $order)) {
            throw new HttpException(500, "Произошла ошибка исполнения платежа");
        }

        $payment = $this->getComponent()->createPayment($order);

        return $this->controller->redirect($payment->confirmation->getConfirmationUrl());
    }

    /**
     * @return null|object
     * @throws \yii\base\InvalidConfigException
     */
    private function getComponent()
    {
        return \Yii::$app->get($this->componentName);
    }
}