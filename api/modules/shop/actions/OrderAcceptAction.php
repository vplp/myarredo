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

    public $scenario = Model::SCENARIO_DEFAULT;

    /**
     * @param $id
     * @return Order
     * @throws ServerErrorHttpException
     * @throws \yii\base\InvalidConfigException
     */
    public function run()
    {
        /** @var $model Order */

        $model = new $this->modelClass([
            'scenario' => $this->scenario,
        ]);

        $model->load(Yii::$app->getRequest()->getBodyParams(), '');
        if ($model->save()) {
            Yii::$app->getResponse()->setStatusCode(204);
        } elseif (!$model->hasErrors()) {
            throw new ServerErrorHttpException('Failed to create the object for unknown reason.');
        }

        return $model;
    }
}
