<?php

namespace frontend\modules\catalog\models;

use Yii;
use yii\helpers\Url;

/**
 * Class Category
 *
 * @package frontend\modules\catalog\models
 */
class Category extends \common\modules\catalog\models\Category
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
     * @param $id
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
        return (new search\Category())->search($params);
    }

    /**
     * @param string $alias
     * @return string
     */
    public static function getUrl(string $alias)
    {
        return Url::toRoute(['/catalog/category/list', 'filter' => $alias]);
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
        } else {
            $image = 'http://placehold.it/200x200';
        }
        return $image;
    }

    /**
     * @param array $params
     * @return mixed
     */
    public static function getAllWithFilter($params = [])
    {
        $query = self::findBase();

        if (isset($params['type'])) {
            $query->innerJoinWith(["types"])
                ->andFilterWhere([TypesRelCategory::tableName() . '.type_id' => $params['type']['id']]);
        }

        return $query->all();
    }
}