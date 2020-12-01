<?php

namespace api\modules\shop\actions;

use Yii;
use yii\base\Model;
use yii\rest\Action;
use api\modules\shop\models\Order;

/**
 * Class OrderAcceptAction
 *
 * @package api\modules\shop\actions
 */
class OrderAcceptAction extends Action
{
    public $modelClass;

    public $scenario = Model::SCENARIO_DEFAULT;

    /**
     * @return array[]
     */
    public function run()
    {
        /** @var $model Order */

        Yii::$app
            ->mailer
            ->compose(
                'order_accept_action',
                [
                    'post' => Yii::$app->getRequest()->getBodyParams('order'),
                ]
            )
            ->setTo('zndron@gmail.com')
            ->setSubject('Яндекс.Турбо')
            ->send();

        $response = [
            'order' => [
                'accepted' => false, 'reason' => null
            ]
        ];

        if ($cart = Yii::$app->getRequest()->getBodyParams('order')) {
            $new_order = Order::addNewOrder($cart);

            if ($new_order) {
                $response['order']['accepted'] = true;
                $response['order']['id'] = $new_order['id'];
            }
        }

        return $response;
    }
}
