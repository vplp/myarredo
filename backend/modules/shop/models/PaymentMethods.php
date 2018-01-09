<?php


namespace backend\modules\shop\models;

use yii\helpers\ArrayHelper;
use common\modules\shop\models\PaymentMethods as CommonPaymentMethodsModel;
use thread\app\model\interfaces\BaseBackendModel;



/**
 * Class PaymentMethods
 *
 * @package backend\modules\shop\models
 */
class PaymentMethods extends CommonPaymentMethodsModel implements BaseBackendModel
{
    /**
     * @param $params
     * @return \yii\data\ActiveDataProvider
     */
    public function search($params)
    {
        return (new search\PaymentMethods())->search($params);
    }

    /**
     * @param $params
     * @return \yii\data\ActiveDataProvider
     */
    public function trash($params)
    {
        return (new search\PaymentMethods())->trash($params);
    }
    
    /**
     * Backend form dropdown list
     * @return array
     */
    public static function dropDownList()
    {
        return ArrayHelper::map(self::findBase()->joinWith(['lang'])->undeleted()->all(), 'id', 'lang.title');
    }
}
