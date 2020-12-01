<?php

namespace api\modules\shop\actions;

use Yii;
use yii\base\Model;
use yii\rest\Action;

/**
 * Class OrderStatusAction
 *
 * @package api\modules\shop\actions
 */
class OrderStatusAction extends Action
{
    public $modelClass;

    public $scenario = Model::SCENARIO_DEFAULT;

    /**
     * @return \yii\console\Response|\yii\web\Response
     */
    public function run()
    {
        Yii::$app
            ->mailer
            ->compose(
                'order_accept_action',
                [
                    'post' => Yii::$app->getRequest()->getBodyParams('order'),
                ]
            )
            ->setTo('zndron@gmail.com')
            ->setSubject('Яндекс.Турбо OrderStatus')
            ->send();

        return Yii::$app->getResponse()->setStatusCode(200);
    }
}
