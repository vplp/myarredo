<?php

namespace frontend\modules\catalog\models;

use Yii;
use yii\helpers\ArrayHelper;
//
use common\modules\catalog\models\Product as CommonProduct;

/**
 * Class FactoryProduct
 *
 * @package frontend\modules\catalog\models
 */
class FactoryProduct extends \common\modules\catalog\models\Product
{
    public $promotion;

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
        if (Yii::$app->user->identity->group->role == 'factory') {
            $this->user_id = Yii::$app->user->identity->id;
            $this->factory_id = Yii::$app->user->identity->profile->factory_id;
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
                'price',
                'volume',
                'factory_price',
                'price_from',
                'is_composition',
                //'popular',
                //'novelty',
                //'bestseller',
                //'onmain',
                //'published',
                //'deleted',
                //'removed',
                //'in_stock',
                //'moderation',
                //'country_code',
                //'user',
                'alias',
                'default_title',
                'article',
                'category_ids',
                'samples_ids',
                //'factory_catalogs_files_ids',
                //'factory_prices_files_ids',
            ]
        ]);
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return ArrayHelper::merge(CommonProduct::attributeLabels(), []);
    }

    /**
     * @return mixed
     */
    public static function findBase()
    {
        return self::find()
            ->innerJoinWith(['lang', 'factory'])
            ->andWhere([self::tableName() . '.factory_id' => Yii::$app->user->identity->profile->factory_id])
            ->orderBy(self::tableName() . '.updated_at DESC');
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
}