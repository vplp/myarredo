<?php

namespace frontend\modules\page\models;

use yii\helpers\Url;

/**
 * Class Page
 *
 * @package frontend\modules\page\models
 * @author Andrii Bondarchuk
 * @copyright (c) 2016
 */
class Page extends \common\modules\page\models\Page
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
     *
     * @return yii\db\ActiveQuery
     */
    public static function find_base()
    {
        return parent::find()->enabled();
    }

    /**
     *
     * @param string $alias
     * @return ActiveRecord|null
     */
    public static function findByAlias($alias)
    {
        return self::find_base()->alias($alias)->one();
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
