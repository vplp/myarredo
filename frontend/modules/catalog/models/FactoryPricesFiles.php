<?php

namespace frontend\modules\catalog\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * Class FactoryPricesFiles
 *
 * @package frontend\modules\catalog\models
 */
class FactoryPricesFiles extends \common\modules\catalog\models\FactoryPricesFiles
{
    /**
     * @return array
     */
    public function behaviors()
    {
        return ArrayHelper::merge(parent::behaviors(), []);
    }

    /**
     * @return array
     */
    public function rules()
    {
        return ArrayHelper::merge(parent::rules(), []);
    }

    /**
     * @return array
     */
    public function scenarios()
    {
        return ArrayHelper::merge(parent::scenarios(), [
            'frontend' => [
                'factory_id',
                //'discount',
                'title',
                'file_link',
                //'image_link',
                'file_type',
                'file_size',
                //'position',
                //'published',
                //'deleted'
            ],
        ]);
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return ArrayHelper::merge(parent::attributeLabels(), []);
    }

    /**
     * @param bool $insert
     * @return bool
     * @throws \Throwable
     */
    public function beforeSave($insert)
    {
        if (!Yii::$app->getUser()->isGuest && Yii::$app->user->identity->group->role == 'factory') {
            $this->factory_id = Yii::$app->user->identity->profile->factory_id;
        }

        return parent::beforeSave($insert);
    }

    public function getProduct()
    {
        return $this
            ->hasMany(Product::class, ['id' => 'catalog_item_id'])
            ->viaTable(ProductRelFactoryPricesFiles::tableName(), ['factory_file_id' => 'id']);
    }

    /**
     * @return mixed
     */
    public static function findBase()
    {
        return parent::findBase();
    }

    /**
     * @param $id
     * @return mixed
     */
    public static function findById($id)
    {
        return self::findBase()->byId($id)->one();
    }

    /**
     * @param $params
     * @return \yii\data\ActiveDataProvider
     * @throws \Throwable
     * @throws \yii\base\InvalidConfigException
     */
    public function search($params)
    {
        return (new search\FactoryPricesFiles())->search($params);
    }
}
