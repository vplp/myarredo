<?php

namespace frontend\modules\page\models;

use yii\helpers\Url;
//
use thread\app\model\interfaces\BaseFrontModel;

/**
 * Class Page
 *
 * @package frontend\modules\page\models
 * @author Andrii Bondarchuk
 * @copyright (c) 2016
 */
class Page extends \common\modules\page\models\Page implements BaseFrontModel
{
    /**
     *
     * @return array
     */
    public function behaviors()
    {
        return [];
    }

    /**
     *
     * @return array
     */
    public function scenarios()
    {
        return [];
    }

    /**
     *
     * @return array
     */
    public function attributeLabels()
    {
        return [];
    }

    /**
     *
     * @return array
     */
    public function rules()
    {
        return [];
    }

    /**
     * @return mixed
     */
    public static function find()
    {
        return parent::find()->enabled();
    }

    /**
     * @return mixed
     */
    public static function find_base()
    {
        return parent::find();
    }

    /**
     * @param $id
     * @return mixed
     */
    public static function findById($id)
    {
        return self::find_base()->byID($id)->one();
    }

    /**
     *
     * @param string $alias
     * @return ActiveRecord|null
     */
    public static function findByAlias($alias)
    {
        return self::find_base()->byAlias($alias)->one();
    }

    /**
     * Url route to view particular page
     * @param null $schema
     * @return string
     */
    public function getUrl($schema = null)
    {
        return Url::toRoute(['/page/page/view', 'alias' => $this->alias], $schema);
    }
}
