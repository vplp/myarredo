<?php

namespace common\modules\shop\modules\market\models;

use Yii;
use yii\helpers\ArrayHelper;
use common\modules\shop\Shop;
use common\modules\user\models\User;
use thread\app\base\models\ActiveRecord;
use voskobovich\behaviors\ManyToManyBehavior;

/**
 * Class MarketOrder
 *
 * @property integer $id
 * @property integer $winner_id
 * @property integer $full_name
 * @property integer $email
 * @property integer $country_id
 * @property integer $city_id
 * @property integer $comment
 * @property integer $cost
 * @property integer $currency
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $published
 * @property integer $deleted
 *
 * @property array $partner_ids
 *
 * @property MarketOrderRelPartner[] $partners
 * @property MarketOrderAnswer[] $answers
 * @property MarketOrderAnswer $answer
 *
 * @package common\modules\shop\models
 */
class MarketOrder extends ActiveRecord
{
    /**
     * @return null|object
     */
    public static function getDb()
    {
        return Shop::getDb();
    }

    /**
     * @return string
     */
    public static function tableName()
    {
        return '{{%shop_market_order}}';
    }

    /**
     * @return array
     */
    public function behaviors()
    {
        return ArrayHelper::merge(parent::behaviors(), [
            [
                'class' => ManyToManyBehavior::className(),
                'relations' => [
                    'partner_ids' => 'partners',
                ],
            ],
        ]);
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['email', 'full_name', 'cost', 'currency', 'country_id', 'comment'], 'required'],
            [['comment'], 'string', 'max' => 512],
            [['winner_id', 'country_id', 'city_id', 'created_at', 'updated_at'], 'integer'],
            [['cost'], 'double'],
            [['currency'], 'in', 'range' => array_keys(static::currencyRange())],
            [['published', 'deleted'], 'in', 'range' => array_keys(self::statusKeyRange())],
            [['partner_ids'], 'each', 'rule' => ['integer']],
            [['partner_ids'], 'required'],
            [['winner_id', 'city_id'], 'default', 'value' => 0],
        ];
    }

    /**
     * @return array
     */
    public function scenarios()
    {
        return [
            'published' => ['published'],
            'deleted' => ['deleted'],
            'frontend' => [
                'winner_id',
                'email',
                'full_name',
                'country_id',
                'city_id',
                'comment',
                'cost',
                'currency',
                'published',
                'deleted',
                'partner_ids',
            ],
        ];
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'winner_id' => Yii::t('app', 'Winner'),
            'email' => Yii::t('app', 'Email'),
            'full_name' => Yii::t('app', 'Name'),
            'country_id' => Yii::t('app', 'Country'),
            'city_id' => Yii::t('app', 'City'),
            'comment' => Yii::t('app', 'Comment'),
            'cost' => Yii::t('app', 'Cost'),
            'currency' => Yii::t('app', 'Currency'),
            'created_at' => Yii::t('app', 'Create time'),
            'updated_at' => Yii::t('app', 'Update time'),
            'published' => Yii::t('app', 'Published'),
            'deleted' => Yii::t('app', 'Deleted'),
            'partner_ids' => Yii::t('app', 'Partners'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     * @throws \yii\base\InvalidConfigException
     */
    public function getPartners()
    {
        return $this
            ->hasMany(User::class, ['id' => 'user_id'])
            ->viaTable(MarketOrderRelPartner::tableName(), ['order_id' => 'id']);
    }

    /**
     * @return mixed
     */
    public function getAnswers()
    {
        return $this
            ->hasMany(MarketOrderAnswer::class, ['order_id' => 'id']);
    }

    /**
     * @return mixed
     */
    public function getAnswer()
    {
        $modelAnswer = MarketOrderAnswer::findByOrderIdUserId(
            $this->id,
            Yii::$app->getUser()->getId()
        );

        if ($modelAnswer == null) {
            $modelAnswer = new MarketOrderAnswer();
        }

        return $modelAnswer;
    }

    /**
     * @return array
     */
    public static function currencyRange()
    {
        return [
            'EUR' => 'EUR',
            'RUB' => 'RUB',
            'USD' => 'USD'
        ];
    }

    /**
     * @return bool
     */
    public function isWinner()
    {
        return $this->winner_id == Yii::$app->user->id ? true : false;
    }
}
