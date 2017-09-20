<?php

namespace frontend\modules\catalog\models;

use yii\helpers\Url;

/**
 * Class Sale
 *
 * @package frontend\modules\catalog\models
 */
class Sale extends \common\modules\catalog\models\Sale
{
//    /**
//     * @return array
//     */
//    public function behaviors()
//    {
//        return [];
//    }

//    /**
//     * @return array
//     */
//    public function scenarios()
//    {
//        return parent::scenarios();
//    }
//
//    /**
//     * @return array
//     */
//    public function attributeLabels()
//    {
//        return [];
//    }
//
//    /**
//     * @return array
//     */
//    public function rules()
//    {
//        return [];
//    }


    /**
     * Get by alias
     *
     * @param string $alias
     * @return ActiveRecord|null
     */
    public static function findByAlias($alias)
    {
        return self::findBase()->byAlias($alias)->enabled()->one();
    }

    /**
     * @param $id
     * @return mixed
     */
    public static function findById($id)
    {
        return self::findBase()->byId($id)->enabled()->one();
    }

    /**
     * @param $params
     * @return \yii\data\ActiveDataProvider
     */
    public function search($params)
    {
        return (new search\Sale())->search($params);
    }

    /**
     * @param $params
     * @return \yii\data\ActiveDataProvider
     */
    public function trash($params)
    {
        return (new search\Sale())->trash($params);
    }

    /**
     * @param $params
     * @return \yii\data\ActiveDataProvider
     */
    public function partnerSearch($params)
    {
        return (new search\Sale())->partnerSearch($params);
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return Url::toRoute(['/catalog/sale/view', 'alias' => $this->alias]);
    }

    /**
     * @return string
     */
    public function getUrlUpdate()
    {
        return Url::toRoute(['/catalog/partner-sale/update', 'id' => $this->id]);
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
     * @return string
     */
    public function getTitle()
    {
        $title = (($this->catalog_type_id > 0 && !empty($this->types)) ? $this->types->lang->title . ' ' : '');
        $title .= $this->getFactoryTitle();

        return $title;
    }

    /**
     * @return string
     */
    public function getFactoryTitle()
    {
        $title = !empty($this->factory->lang) ? $this->factory->lang->title : '';
        $title .= ' ' . !empty($this->factory_name) ? $this->factory_name : '';

        return $title;
    }
}