<?php

namespace frontend\modules\catalog\models;

use yii\helpers\Url;

/**
 * Class Product
 *
 * @package frontend\modules\catalog\models
 */
class Product extends \common\modules\catalog\models\Product
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
        return self::findBase()
            ->byAlias($alias)
            ->innerJoinWith([
                'category' => function ($q) {
                    $q->with(['lang']);
                }]
            )
            ->one();
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
        return (new search\Product())->search($params);
    }

    /**
     * @param string $alias
     * @return string
     */
    public static function getUrl(string $alias)
    {
        return Url::toRoute(['/catalog/product/view', 'alias' => $alias]);
    }

    /**
     * @param array $model
     * @param array $types
     * @param array $collections
     * @return string
     */
    public static function getTitle(array $model, array $types = [], array $collections = [])
    {
        // TODO: !!!

//        $title = (($this->catalog_type_id > 0 && !empty($this->types)) ? $this->types->lang->title . ' ' : '');
//        $title .= (($this->collections_id > 0 && !empty($this->collection)) ? $this->collection->lang->title . ' ' : '');
//        $title .= ((!$this->is_composition && !empty($this->article)) ? $this->article . ' ' : '');
//        $title = (($this->is_composition) ? $this->getСompositionTitle() : '') . $title;

        $title = '';

        if ($types)
            $title .= $types['lang']['title'] . ' ';

        if ($collections)
            $title .= $collections['lang']['title'] . ' ';

        $title .= $model['article'];

        return $title;
    }
}