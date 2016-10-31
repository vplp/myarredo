<?php


namespace frontend\modules\shop\models;

use yii\helpers\ArrayHelper;
use common\modules\shop\models\PaymentMethods as CommonPaymentMethodsModel;


/**
 * Class PaymentMethods
 *
 * @package frontend\modules\shop\models
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c) 2015, Thread
 */
class PaymentMethods extends CommonPaymentMethodsModel
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
        return self::findBase()->alias($alias)->one();
    }

    /**
     * @param $alias
     * @return mixed
     */
    public static function findIdByAlias($alias)
    {
        return self::find()->alias($alias)->select('id')->enabled()->asarray()->one();
    }
}
