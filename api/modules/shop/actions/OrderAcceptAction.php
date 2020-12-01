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

        $bodyParams = Yii::$app->getRequest()->getBodyParams();

        Yii::$app
            ->mailer
            ->compose(
                'order_accept_action',
                [
                    'post' => $bodyParams,
                ]
            )
            ->setTo('zndron@gmail.com')
            ->setSubject('Яндекс.Турбо OrderAccept')
            ->send();

        $response = [
            'order' => [
                'accepted' => false, 'reason' => null
            ]
        ];

        if (isset($bodyParams['order'])) {
            $new_order = Order::addNewOrder($bodyParams['order']);

            if ($new_order) {
                $response['order']['accepted'] = true;
                $response['order']['id'] = $new_order['id'];
            }
        }

        return $response;
    }
}
