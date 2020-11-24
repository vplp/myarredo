<?php

namespace api\modules\shop\actions;

use Yii;
use yii\base\Model;
use yii\rest\Action;
use yii\web\ServerErrorHttpException;
use api\modules\shop\models\Order;

/**
 * Class OrderAcceptAction
 *
 * @package api\modules\shop\actions
 */
class OrderAcceptAction extends Action
{
    public $modelClass;

    /**
     * @param $id
     * @return Order
     * @throws ServerErrorHttpException
     * @throws \yii\base\InvalidConfigException
     */
    public function run()
    {
        /** @var $model Order */

        if ($order = Yii::$app->getRequest()->getBodyParams('order')) {
            $model = new $this->modelClass([
                'scenario' => 'addNewOrder',
            ]);

            // add new Customer

            // create

        }


        ///* !!! */ echo  '<pre style="color:red;">'; print_r(Yii::$app->getRequest()->getBodyParams()); echo '</pre>'; /* !!! */

//        if ($model->save()) {
//            Yii::$app->getResponse()->setStatusCode(204);
//        } elseif (!$model->hasErrors()) {
//            throw new ServerErrorHttpException('Failed to create the object for unknown reason.');
//        }

        return ['order' => ['accepted' => false, 'reason' => 'OUT_OF_DATE']];
    }
}
