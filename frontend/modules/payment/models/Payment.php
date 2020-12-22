<?php

namespace frontend\modules\payment\models;

use Yii;
use yii\helpers\Url;
//
use frontend\modules\catalog\models\{
    ItalianProduct, FactoryPromotion
};

/**
 * Class Payment
 *
 * @package frontend\modules\payment\models
 */
class Payment extends \common\modules\payment\models\Payment
{
    public function init()
    {
        parent::init();

        $this->on(self::EVENT_AFTER_UPDATE, [$this, 'sendLetterNotificationPaidForAdmin']);
        $this->on(self::EVENT_AFTER_UPDATE, [$this, 'setTimePromotion']);
    }

    /**
     * @return mixed
     */
    public static function findBase()
    {
        return parent::findBase()->enabled();
    }

    /**
     * @param $params
     * @return mixed|\yii\data\ActiveDataProvider
     * @throws \Throwable
     * @throws \yii\base\InvalidConfigException
     */
    public function search($params)
    {
        return (new search\Payment())->search($params);
    }

    public function setTimePromotion()
    {
        if ($this->payment_status == 'success' &&
            in_array($this->type, ['promotion_item', 'promotion_sale_item', 'promotion_italian_item'])
        ) {
            $time = mktime(0, 0, 0, date("m"), date("d") + 10, date("Y"));

            switch ($this->promotion_package_id) {
                case 1:
                    foreach ($this->items as $item) {
                        $item->setScenario('turbo_sale_2in1');
                        $item->time_vip_promotion_in_catalog = $time;
                        $item->time_vip_promotion_in_category = $time;
                        $item->save();
                    }
                    break;
                case 2:
                    foreach ($this->items as $item) {
                        $item->setScenario('time_promotion_in_catalog');
                        $item->time_promotion_in_catalog = $time;
                        $item->save();
                    }
                    break;
                case 3:
                    foreach ($this->items as $item) {
                        $item->setScenario('time_promotion_in_category');
                        $item->time_promotion_in_category = $time;
                        $item->save();
                    }
                    break;
                case 4:
                    foreach ($this->items as $item) {
                        $item->setScenario('time_vip_promotion_in_catalog');
                        $item->time_vip_promotion_in_catalog = $time;
                        $item->save();
                    }
                    break;
                case 5:
                    foreach ($this->items as $item) {
                        $item->setScenario('time_vip_promotion_in_category');
                        $item->time_vip_promotion_in_category = $time;
                        $item->save();
                    }
                    break;
            }
        }
    }

    public function getTimePromotion()
    {
        $time = 0;

        if ($this->payment_status == 'success') {
            switch ($this->promotion_package_id) {
                case 1:
                    foreach ($this->items as $item) {
                        $time = $item->time_vip_promotion_in_catalog;
                        //$time = $item->time_vip_promotion_in_category;
                    }
                    break;
                case 2:
                    foreach ($this->items as $item) {
                        $time = $item->time_promotion_in_catalog;
                    }
                    break;
                case 3:
                    foreach ($this->items as $item) {
                        $time = $item->time_promotion_in_category;
                    }
                    break;
                case 4:
                    foreach ($this->items as $item) {
                        $time = $item->time_vip_promotion_in_catalog;
                    }
                    break;
                case 5:
                    foreach ($this->items as $item) {
                        $time = $item->time_vip_promotion_in_category;
                    }
                    break;
            }
        }

        return date('d-m-Y', $time);
    }

    /**
     * sendLetterNotificationForAdmin
     */
    public function sendLetterNotificationPaidForAdmin()
    {
        /** send mail to admin */

        if ($this->payment_status == 'success') {
            $title = $this->getInvDesc();

            $message = $this->amount . ' ' . $this->currency;

            $url = '';

            if ($this->type == 'factory_promotion') {
                $url = Url::home(true) . 'backend/catalog/factory-promotion/update?id=' . $this->id;
            } elseif ($this->type == 'italian_item') {
                $url = Url::home(true) . 'backend/catalog/sale-italy/update?id=' . $this->id;
            } elseif ($this->type == 'tariffs') {
                $message .= '<br>' . $this->tariffs;
            }

            Yii::$app
                ->mailer
                ->compose(
                    'letter_notification_for_admin',
                    [
                        'title' => $title,
                        'message' => $message,
                        'url' => $url,
                        'model' => $this,
                    ]
                )
                ->setTo(\Yii::$app->params['mailer']['setTo'])
                ->setSubject($message)
                ->send();
        }
    }
}
