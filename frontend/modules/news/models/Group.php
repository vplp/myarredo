<?php

namespace frontend\modules\news\models;

use Yii;
use yii\helpers\Url;

/**
 * Class Group
 *
 * @package frontend\modules\news\models
 * @author Andrii Bondarchuk
 * @copyright (c) 2016
 */

class Group extends \backend\modules\news\models\Group
{
    /**
     *
     * @return array
     */
    public function behaviors() {
        return [];
    }

    /**
     *
     * @return array
     */
    public function scenarios() {
        return [];
    }

    /**
     *
     * @return array
     */
    public function attributeLabels() {
        return [];
    }

    /**
     *
     * @return array
     */
    public function rules() {
        return [];
    }

    /**
     *
     * @return yii\db\ActiveQuery
     */
    public static function find_base() {
        return self::find()->innerJoinWith(["lang"])->enabled();
    }

    /**
     *
     * @return string
     */
    public function getUrl() {
        return Url::toRoute(['/news/list/index', 'alias' => $this->alias]);
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
