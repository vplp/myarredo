<?php

namespace frontend\modules\banner\models;

use yii\helpers\Url;
use Yii;

/**
 * Class BannerItem
 *
 * @package frontend\modules\banner\models
 */
class BannerItem extends \common\modules\banner\models\BannerItem
{

//    /**
//     *
//     * @return array
//     */
//    public function behaviors() {
//        return [];
//    }

//    /**
//     *
//     * @return array
//     */
//    public function scenarios() {
//        return [];
//    }

//    /**
//     *
//     * @return array
//     */
//    public function attributeLabels() {
//        return [];
//    }

//    /**
//     *
//     * @return array
//     */
//    public function rules() {
//        return [];
//    }

    /**
     *
     * @return yii\db\ActiveQuery
     */
    public static function findBase()
    {
        return parent::findBase()->undeleted();
    }

    /**
     * @param $id
     * @return mixed
     */
    public static function findById($id)
    {
        return self::findBase()
            ->byID($id)
            ->published()
            ->one();
    }

    /**
     * @param $factory_id
     * @return array|null|\yii\db\ActiveRecord
     */
    public static function findByFactoryId($factory_id)
    {
        return self::findBase()
            ->andWhere([self::tableName() . '.factory_id' => $factory_id])
            ->published()
            ->all();
    }

    /**
     * @param $params
     * @return \yii\data\ActiveDataProvider
     */
    public function search($params)
    {
        return (new search\BannerItem())->search($params);
    }

    /**
     * @param $params
     * @return \yii\data\ActiveDataProvider
     */
    public function trash($params)
    {
        return (new search\BannerItem())->trash($params);
    }
}
