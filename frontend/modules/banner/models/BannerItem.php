<?php

namespace frontend\modules\banner\models;

use yii\helpers\Url;
use Yii;

/**
 * Class BannerItem
 *
 * @package frontend\modules\banner\models
 */
class BannerItem extends \common\modules\banner\models\BannerItem {

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
    public static function findBase() {
        return parent::findBase()->enabled();
    }

    /**
     * @param $id
     * @return mixed
     */
    public static function findById($id) {
        return self::findBase()->byID($id)->one();
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
