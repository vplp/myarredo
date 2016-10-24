<?php


namespace frontend\modules\shop\models;

use yii\helpers\ArrayHelper;
use common\modules\shop\models\DeliveryMethods as CommonDeliveryMethodsModel;


/**
 * Class DeliveryMethods
 *
 * @package frontend\modules\shop\models
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c) 2015, Thread
 */
class DeliveryMethods extends CommonDeliveryMethodsModel
{

    /**
     *
     * @return yii\db\ActiveQuery
     */
    public static function findBase()
    {
        return self::find()->innerJoinWith(['lang'])->enabled();
    }


    /**
     * Backend form dropdown list
     * @return array
     */
    public static function dropDownList()
    {
        return ArrayHelper::map(self::findBase()->all(), 'id', 'lang.title');
    }
}
