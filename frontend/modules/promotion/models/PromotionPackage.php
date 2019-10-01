<?php

namespace frontend\modules\promotion\models;

use yii\helpers\Url;

/**
 * Class PromotionPackage
 *
 * @package frontend\modules\promotion\models
 */
class PromotionPackage extends \common\modules\promotion\models\PromotionPackage
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
        return parent::findBase()->enabled();
    }
}
