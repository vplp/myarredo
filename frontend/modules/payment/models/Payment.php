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

    /**
     * sendLetterNotificationForAdmin
     */
    public function sendLetterNotificationPaidForAdmin()
    {
        /** send mail to admin */

        if ($this->payment_status == 'success') {
            $title = ($this->type == 'factory_promotion')
                ? Yii::t('app', 'Оплата рекламной кампании')
                : Yii::t('app', 'Оплата товаров');

            $message = $this->amount . ' ' . $this->currency;

            $url = ($this->type == 'factory_promotion')
                ? Url::home(true) . 'backend/catalog/factory-promotion/update?id=' . $this->id
                : Url::home(true) . 'backend/catalog/sale-italy/update?id=' . $this->id;

            Yii::$app
                ->mailer
                ->compose(
                    '@app/modules/catalog/mail/letter_notification_for_admin',
                    [
                        'title' => $title,
                        'message' => $message,
                        'url' => $url,
                        'model' => $this,
                    ]
                )
                ->setTo(Yii::$app->params['mailer']['setTo'])
                ->setSubject($message)
                ->send();
        }
    }

    /**
     * @return \yii\db\ActiveQuery
     * @throws \yii\base\InvalidConfigException
     */
    public function getItems()
    {
        $class = ($this->type == 'factory_promotion')
            ? FactoryPromotion::class
            : ItalianProduct::class;

        return $this
            ->hasMany($class, ['id' => 'item_id'])
            ->viaTable(PaymentRelItem::tableName(), ['payment_id' => 'id']);
    }
}
