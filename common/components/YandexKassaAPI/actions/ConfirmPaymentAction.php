<?php

namespace common\components\YandexKassaAPI\actions;

use yii\base\Action;
use yii\web\HttpException;
//
use common\components\YandexKassaAPI\YandexKassaAPI;
use common\components\YandexKassaAPI\interfaces\PaymentInterface;

/**
 * Class ConfirmPaymentAction
 *
 * @package common\components\YandexKassaAPI\actions
 */
class ConfirmPaymentAction extends Action
{
    /**
     * Should return true||false
     * @var callable
     */
    public $beforeConfirm;

    public $componentName = "yandexKassa";

    /**
     * @var
     */
    public $orderClass;

    /**
     * это нужно чтобы пост от яндекса проходил
     */
    public function init()
    {
        parent::init();

        $this->controller->enableCsrfValidation = false;
    }

    /**
     * @return bool
     * @throws HttpException
     * @throws \yii\base\InvalidConfigException
     */
    public function run()
    {
        $request = json_decode(file_get_contents('php://input'));

        $orderModel = \Yii::createObject($this->orderClass);

        if (!$orderModel instanceof PaymentInterface) {
            throw new HttpException(500, "Модель должна реализовывать интерфейс PaymentInterface");
        }

        $order = $orderModel->findByInvoiceId($request->object->id)->one();

        if (!$request->object->paid) {
            return false;
        }

        if ($this->beforeConfirm && call_user_func_array($this->beforeConfirm, [$request, $order])) {
            $this->getComponent()->confirmPayment($request->object->id, $order);
        }
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