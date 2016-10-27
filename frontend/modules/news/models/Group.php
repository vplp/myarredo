<?php

namespace frontend\modules\news\models;

use Yii;
use yii\helpers\Url;
//
use thread\app\model\interfaces\BaseFrontModel;

/**
 * Class Group
 *
 * @package frontend\modules\news\models
 * @author Andrii Bondarchuk
 * @copyright (c) 2016
 */
class Group extends \backend\modules\news\models\Group implements BaseFrontModel
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
        return self::find()->innerJoinWith(["lang"]);
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
     * @param $id
     * @return mixed
     */
    public static function findByAlias($id)
    {
        return self::find_base()->alias($alias)->one();
    }

    /**
     * @param bool|false $scheme
     * @return string
     */
    public function getUrl($scheme = false)
    {
        return Url::toRoute(['/news/list/index', 'alias' => $this->alias], $scheme);
    }

    /**
     * Get list
     * @return mixed
     */
    public static function getList()
    {
        return self::findBase()->all();
    }
}
