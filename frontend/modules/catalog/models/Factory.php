<?php

namespace frontend\modules\catalog\models;

use Yii;
use yii\helpers\Url;

/**
 * Class Factory
 *
 * @package frontend\modules\catalog\models
 */
class Factory extends \common\modules\catalog\models\Factory
{
    /**
     * @return array
     */
    public function behaviors()
    {
        return [];
    }

    /**
     * @return array
     */
    public function scenarios()
    {
        return [];
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return [];
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [];
    }

    /**
     * @return mixed
     */
    public static function findBase()
    {
        return parent::findBase()->enabled()->asArray();
    }

    /**
     * Get by alias
     *
     * @param string $alias
     * @return ActiveRecord|null
     */
    public static function findByAlias($alias)
    {
        return self::findBase()->byAlias($alias)->one();
    }

    /**
     * @return int|string
     */
//    public function getProductCount()
//    {
//        return $this->getProduct()
//            ->innerJoinWith('lang')
//            ->andWhere(['is_composition' => '0'])
//            ->enabled()
//            ->count();
//    }

    /**
     * Search
     *
     * @param $params
     * @return \yii\data\ActiveDataProvider
     */
    public function search($params)
    {
        return (new search\Factory())->search($params);
    }

    /**
     * @param string $alias
     * @return string
     */
    public static function getUrl(string $alias)
    {
        return Url::toRoute(['/catalog/factory/view', 'alias' => $alias]);
    }

    /**
     * @param string $image_link
     * @return null|string
     */
    public static function getImage(string $image_link)
    {
        /** @var Catalog $module */
        $module = Yii::$app->getModule('catalog');
        $path = $module->getCategoryUploadPath();
        $url = $module->getCategoryUploadUrl();
        $image = null;
        if (!empty($image_link) && is_file($path . '/' . $image_link)) {
            $image = $url . '/' . $image_link;
        }
        return $image;
    }

    /**
     * @param $params
     * @return mixed
     */
    public static function getAllWithFilter($params = [])
    {
        return self::findBase()
            ->all();
    }
}