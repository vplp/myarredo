<?php


namespace frontend\modules\shop\models;

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
     * @return mixed
     */
    public static function findBase()
    {
        return self::find()->innerJoinWith(['lang'])->enabled();
    }


    /**
     * @param $alias
     * @return mixed
     */
    public static function findByAlias($alias)
    {
        return self::findBase()->byAlias($alias)->one();
    }


    /**
     * @param $alias
     * @return mixed
     */
    public static function findIdByAlias($alias)
    {
        return self::find()->byAlias($alias)->select('id')->enabled()->asArray()->one();
    }


}
