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
        return self::find()
            ->innerJoinWith(['lang'])
            ->orderBy('updated_at DESC')
            ->enabled()
            ->asArray();
    }

    /**
     * Get by alias
     *
     * @param string $alias
     * @return ActiveRecord|null
     */
    public static function findByAlias($alias)
    {
        return self::find()
            ->innerJoinWith(['lang'])
            ->orderBy('updated_at DESC')
            ->enabled()
            ->byAlias($alias)
            ->innerJoinWith([
                'category' => function ($q) {
                    $q->with(['lang']);
                }]
            )
            ->one();
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
     * @return null|string
     */
    public static function getImage()
    {
        $image =  'http://placehold.it/200x200';

        return $image;
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
    public static function getTitle(array $model,  $types = null,  $collections = null)
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

        if (!$model['is_composition'])
            $title .= $model['article'];

        if ($model['is_composition'])
            $title = 'КОМПОЗИЦИЯ ' . $title;


        return $title;
    }

    /**
     * @param $collections_id
     * @param $catalog_type_id
     * @return mixed
     */
    public static function getProductByCollection(int $collections_id, int $catalog_type_id)
    {
        return parent::findBase()
            ->enabled()
            ->andFilterWhere([
                'collections_id' => $collections_id,
                'catalog_type_id' => $catalog_type_id
            ])
            ->orderBy('RAND()')
            ->limit(12)
            ->all();
    }

    /**
     * @param $factory_id
     * @param $catalog_type_id
     * @return mixed
     */
    public static function getProductByFactory($factory_id, $catalog_type_id)
    {
        return parent::findBase()
            ->enabled()
            ->andFilterWhere([
                'factory_id' => $factory_id,
                'catalog_type_id' => $catalog_type_id
            ])
            ->orderBy('RAND()')
            ->limit(12)
            ->all();
    }
}