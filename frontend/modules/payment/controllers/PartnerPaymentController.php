<?php

namespace frontend\modules\payment\controllers;

use Yii;
use yii\filters\AccessControl;
//
use frontend\components\BaseController;
use frontend\modules\payment\models\{
    Payment, search\Payment as filterPaymentModel
};
use yii\web\ForbiddenHttpException;

/**
 * Class PartnerPaymentController
 *
 * @package frontend\modules\payment\controllers
 */
class PartnerPaymentController extends BaseController
{
    public $title = '';

    public $defaultAction = 'list';

    protected $model = Payment::class;
    protected $filterModel = filterPaymentModel::class;

    /**
     * @return array
     * @throws ForbiddenHttpException
     */
    public function behaviors()
    {
        if (!Yii::$app->getUser()->isGuest &&
            Yii::$app->user->identity->group->role == 'factory' &&
            !Yii::$app->user->identity->profile->factory_id) {
            throw new ForbiddenHttpException(Yii::t('app', 'Access denied without factory id.'));
        }

        return [
            'AccessControl' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['partner', 'factory'],
                    ],
                    [
                        'allow' => false,
                    ],
                ],
            ],
        ];
    }

    /**
     * @return string
     * @throws \Throwable
     * @throws \yii\base\InvalidConfigException
     */
    public function actionList()
    {
        $model = new Payment();

        $params = Yii::$app->request->queryParams ?? [];

        $params['user_id'] = Yii::$app->getUser()->id;
        //$params['type'] = 'italian_item';

        $models = $model->search($params);

        return $this->render('list', [
            'dataProvider' => $models,
            'models' => $models->getModels(),
            'pages' => $models->getPagination(),
        ]);
    }

    /**
     * @return string
     */
    public function actionTariffs()
    {
        $modelPayment = new Payment();
        $modelPayment->setScenario('frontend');

        $modelPayment->user_id = Yii::$app->user->id;
        $modelPayment->type = 'tariffs';
        $modelPayment->amount = 0;
        $modelPayment->currency = 'RUB';

        return $this->render('tariffs', [
            'modelPayment' => $modelPayment,
        ]);
    }
}
