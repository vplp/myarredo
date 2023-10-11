<?php

namespace frontend\modules\seo\modules\info\models;

use yii\helpers\ArrayHelper;

/**
 * Class Info
 *
 * @package frontend\modules\seo\modules\info\models
 */
class Info extends \common\modules\seo\modules\info\models\Info
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
        return parent::find()->innerJoinWith(['lang']);
    }

    /**
     * @return array
     */
    public static function getAllParams()
    {
        return ArrayHelper::map(self::find()->all(), 'alias', 'lang.value');
    }
}
