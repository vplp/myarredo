<?php

namespace frontend\modules\payment\controllers;

use Yii;
use yii\filters\AccessControl;
//
use frontend\components\BaseController;
use frontend\modules\payment\models\{
    Payment, search\Payment as filterPaymentModel
};
//
use thread\actions\ListModel;

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
     */
    public function behaviors()
    {
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
     * @return array
     */
    public function actions()
    {
        return [
            'list1' => [
                'class' => ListModel::class,
                'modelClass' => $this->model,
                'filterModel' => $this->filterModel,
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
        if (!Yii::$app->getUser()->isGuest &&
            in_array(Yii::$app->user->identity->group->role, ['factory', 'partner'])) {
            $params['user_id'] = Yii::$app->getUser()->id;
            $params['type'] = 'italian_item';
        }
        $models = $model->search($params);

        return $this->render('list', [
            'dataProvider' => $models,
            'models' => $models->getModels(),
            'pages' => $models->getPagination(),
        ]);
    }
}
