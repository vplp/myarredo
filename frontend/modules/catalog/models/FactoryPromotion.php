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

        if (!Yii::$app->getUser()->isGuest && in_array(Yii::$app->user->identity->group->role, ['factory', 'partner'])) {
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
            $this->factory_id = Yii::$app->user->identity->profile->factory_id;
        }

        if (!Yii::$app->getUser()->isGuest) {
            $this->user_id = Yii::$app->user->identity->id;
        }

        return parent::beforeValidate();
    }

    /**
     * @return mixed
     */
    public static function findBase()
    {
        $query = parent::findBase();

        if (!Yii::$app->getUser()->isGuest && Yii::$app->user->identity->group->role == 'factory') {
            $query->andWhere([self::tableName() . '.factory_id' => Yii::$app->user->identity->profile->factory_id]);
        } elseif (!Yii::$app->getUser()->isGuest && Yii::$app->user->identity->group->role == 'partner') {
            $query->andWhere([self::tableName() . '.user_id' => Yii::$app->user->id]);
        }

        return $query->enabled();
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
        if (!Yii::$app->getUser()->isGuest && Yii::$app->user->identity->group->role == 'factory') {
            return Url::toRoute(['/catalog/factory-promotion/update', 'alias' => $this->id], true);
        } else {
            return Url::toRoute(['/catalog/italian-promotion/update', 'alias' => $this->id], true);
        }
    }

    /**
     * sendLetterNotificationNewPromotionForAdmin
     */
    public function sendLetterNotificationNewPromotionForAdmin()
    {
        /** send mail to admin */

        $title = 'Создание рекламной компании';
        $message = (!Yii::$app->getUser()->isGuest && Yii::$app->user->identity->group->role == 'factory')
            ? Yii::$app->user->identity->profile->factory->title
            : Yii::$app->user->identity->profile->getNameCompany();

        Yii::$app
            ->mailer
            ->compose(
                'letter_notification_for_admin',
                [
                    'title' => $title,
                    'message' => $message,
                    'url' => Url::home(true) . 'backend/catalog/promotion-product/update?id=' . $this->id,
                ]
            )
            ->setTo(\Yii::$app->params['mailer']['setTo'])
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
            $title = 'Оплата рекламной компании';
            $message = (!Yii::$app->getUser()->isGuest && Yii::$app->user->identity->group->role == 'factory')
                ? Yii::$app->user->identity->profile->factory->title . ': ' . $this->amount_with_vat
                : Yii::$app->user->identity->profile->getNameCompany() . ': ' . $this->amount_with_vat;

            Yii::$app
                ->mailer
                ->compose(
                    'letter_notification2_for_admin',
                    [
                        'title' => $title,
                        'message' => $message,
                        'url' => Url::home(true) . 'backend/catalog/promotion-product/update?id=' . $this->id,
                        'model' => $this,
                    ]
                )
                ->setTo(\Yii::$app->params['mailer']['setTo'])
                ->setSubject($message)
                ->send();
        }
    }
}
