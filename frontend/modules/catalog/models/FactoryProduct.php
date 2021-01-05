<?php

namespace frontend\modules\catalog\models;

use Yii;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
//
use common\modules\catalog\models\Product as CommonProduct;
//
use frontend\modules\payment\models\{
    Payment, PaymentRelItem
};
use frontend\modules\catalog\models\Product as FrontendProduct;

/**
 * Class FactoryProduct
 *
 * @property Payment $payment
 * @property FactoryPromotionRelProduct[] $factoryPromotionRelProduct
 *
 * @package frontend\modules\catalog\models
 */
class FactoryProduct extends FrontendProduct
{
    public $promotion;

    public function init()
    {
        parent::init();

        if (!Yii::$app->getUser()->isGuest && Yii::$app->user->identity->group->role == 'factory') {
            $this->on(self::EVENT_AFTER_INSERT, [$this, 'sendLetterNotificationNewProductForAdmin']);
        }
    }

    /**
     * @return array
     */
    public function behaviors()
    {
        return ArrayHelper::merge(CommonProduct::behaviors(), []);
    }

    /**
     * @return array
     */
    public function rules()
    {
        return ArrayHelper::merge(CommonProduct::rules(), [
            [['catalog_type_id'], 'required', 'on' => 'frontend'],
            [
                [
                    'promotion'
                ],
                'in',
                'range' => array_keys(static::statusKeyRange())
            ],
        ]);
    }

    /**
     * @param bool $insert
     * @return bool
     * @throws \Throwable
     */
    public function beforeSave($insert)
    {
        if (!Yii::$app->getUser()->isGuest && Yii::$app->user->identity->group->role == 'factory') {
            $this->user_id = Yii::$app->user->identity->id;
            $this->factory_id = Yii::$app->user->identity->profile->factory_id;
            $this->mark = '0';
        }

        return parent::beforeSave($insert);
    }

    /**
     * @return array
     */
    public function scenarios()
    {
        return ArrayHelper::merge(CommonProduct::scenarios(), [
            'promotion' => ['promotion'],
            'setImages' => ['image_link', 'gallery_image'],
            'frontend' => [
                'catalog_type_id',
                'user_id',
                'factory_id',
                'collections_id',
                'image_link',
                'gallery_image',
                'created_at',
                'updated_at',
                'position',
                'volume',
                'factory_price',
                'price_from',
                'is_composition',
                'alias',
                'default_title',
                'article',
                'category_ids',
                'samples_ids',
                'mark'
            ]
        ]);
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return ArrayHelper::merge(CommonProduct::attributeLabels(), [
            'title',
            'factory_price' => Yii::t('app', 'Цена в розницу от'),
        ]);
    }

    /**
     * @return mixed
     */
    public static function findBase()
    {
        return self::find()
            ->innerJoinWith(['factory', 'category'])
            ->andWhere([self::tableName() . '.factory_id' => Yii::$app->user->identity->profile->factory_id])
            ->orderBy(self::tableName() . '.updated_at DESC');
    }

    /**
     * @return \yii\db\ActiveQuery
     * @throws \yii\base\InvalidConfigException
     */
    public function getFactoryPromotionRelProduct()
    {
        return $this
            ->hasOne(FactoryPromotion::class, ['id' => 'promotion_id'])
            ->viaTable(FactoryPromotionRelProduct::tableName(), ['catalog_item_id' => 'id'])
            ->cache(7200);
    }

    /**
     * @return \yii\db\ActiveQuery
     * @throws \yii\base\InvalidConfigException
     */
    public function getPayment()
    {
        return $this
            ->hasOne(Payment::class, ['id' => 'payment_id'])
            ->viaTable(PaymentRelItem::tableName(), ['item_id' => 'id'])
            ->andWhere([Payment::tableName() . '.type' => 'promotion_item'])
            ->orderBy(Payment::tableName() . '.id DESC');
    }

    /**
     * @param $params
     * @return \yii\data\ActiveDataProvider
     * @throws \Throwable
     */
    public function search($params)
    {
        return (new search\FactoryProduct())->search($params);
    }

    /**
     * sendLetterNotificationNewProductForAdmin
     */
    public function sendLetterNotificationNewProductForAdmin()
    {
        /** send mail to admin */

        $title = 'Добавление фабрикой нового товара';

        $message = Yii::$app->user->identity->profile->factory->title . ': ' . $this->title;

        Yii::$app
            ->mailer
            ->compose(
                'letter_notification_for_admin',
                [
                    'title' => $title,
                    'message' => $message,
                    'url' => Url::home(true) . 'backend/catalog/product/update?id=' . $this->id,
                ]
            )
            ->setTo(\Yii::$app->params['mailer']['setTo'])
            ->setSubject($title)
            ->send();
    }
}
