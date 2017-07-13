<?php

namespace frontend\modules\user\models;

/**
 * Class Group
 *
 * @package frontend\modules\user\models
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */
class Group extends \common\modules\user\models\Group
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
        return parent::find()->enabled()->innerJoinWith(['lang']);
    }

    /**
     * @return mixed
     */
    public static function findBase()
    {
        return self::find();
    }
}
