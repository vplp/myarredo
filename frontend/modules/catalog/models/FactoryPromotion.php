<?php

namespace frontend\modules\catalog\models;

use Yii;
use yii\helpers\Url;

/**
 * Class Factory
 *
 * @package frontend\modules\catalog\models
 */
class FactoryPromotion extends \common\modules\catalog\models\FactoryPromotion
{
    public function init()
    {
        parent::init();

        if (!Yii::$app->getUser()->isGuest && Yii::$app->user->identity->group->role == 'factory') {
            $this->on(self::EVENT_AFTER_INSERT, [$this, 'sendLetterNotificationNewPromotionForAdmin']);
            $this->on(self::EVENT_AFTER_UPDATE, [$this, 'sendLetterNotificationPaidPromotionForAdmin']);
        }
    }

    /**
     * @return bool
     */
    public function beforeValidate()
    {
        if (!Yii::$app->getUser()->isGuest && Yii::$app->user->identity->group->role == 'factory') {
            $this->user_id = Yii::$app->user->identity->id;
            $this->factory_id = Yii::$app->user->identity->profile->factory_id;
        }

        return parent::beforeValidate();
    }

    /**
     * @return mixed
     */
    public static function findBase()
    {
        return parent::findBase()
            ->andWhere([self::tableName() . '.factory_id' => Yii::$app->user->identity->profile->factory_id])
            ->enabled();
    }

    /**
     * @param int $id
     * @return mixed
     */
    public static function findById($id)
    {
        return self::findBase()->byId($id)->one();
    }

    /**
     * Search
     *
     * @param $params
     * @return \yii\data\ActiveDataProvider
     */
    public function search($params)
    {
        return (new search\FactoryPromotion())->search($params);
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return Url::toRoute(['/catalog/factory-promotion/update', 'alias' => $this->id], true);
    }

    /**
     * sendLetterNotificationNewPromotionForAdmin
     */
    public function sendLetterNotificationNewPromotionForAdmin()
    {
        /** send mail to admin */

        $title = 'Создание фабрикой рекламной компании';

        $message = Yii::$app->user->identity->profile->factory->title;

        Yii::$app
            ->mailer
            ->compose(
                'letter_notification_for_admin',
                [
                    'title' => $title,
                    'message' => $message,
                    'url' => Url::home(true) . 'backend/catalog/factory-promotion/update?id=' . $this->id,
                ]
            )
            ->setTo(Yii::$app->params['mailer']['setTo'])
            ->setSubject($title)
            ->send();
    }

    /**
     * sendLetterNotificationForAdmin
     */
    public function sendLetterNotificationPaidPromotionForAdmin()
    {
        /** send mail to admin */

        if ($this->payment_status == 'success') {
            $message = 'Оплата фабрикой рекламной компании';

            Yii::$app
                ->mailer
                ->compose(
                    'letter_notification2_for_admin',
                    [
                        'message' => $message,
                        'title' => Yii::$app->user->identity->profile->factory->title . ': ' . $this->amount_with_vat,
                        'url' => Url::home(true) . 'backend/catalog/factory-promotion/update?id=' . $this->id,
                        'model' => $this,
                    ]
                )
                ->setTo(Yii::$app->params['mailer']['setTo'])
                ->setSubject($message)
                ->send();
        }
    }
}
