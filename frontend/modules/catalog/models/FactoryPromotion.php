<?php

namespace frontend\modules\catalog\models;

use Yii;
use yii\helpers\{
    Url, ArrayHelper
};

/**
 * Class Factory
 *
 * @package frontend\modules\catalog\models
 */
class FactoryPromotion extends \common\modules\catalog\models\FactoryPromotion
{
    /**
     * @return mixed
     */
    public static function findBase()
    {
        return parent::findBase()->enabled();
    }

    /**
     * Search
     *
     * @param $params
     * @return \yii\data\ActiveDataProvider
     */
    public function search($params)
    {
        return (new search\FactoryPromotion())->search($params);
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return Url::toRoute(['/catalog/factory-promotion/update', 'alias' => $this->id]);
    }
}