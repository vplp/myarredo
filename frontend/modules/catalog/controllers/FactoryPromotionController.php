<?php

namespace frontend\modules\catalog\controllers;

use Yii;
use yii\helpers\{
    ArrayHelper, Url
};
use yii\filters\AccessControl;
//
use frontend\components\BaseController;
use frontend\modules\catalog\models\{
    FactoryPromotion,
    FactoryProduct,
    search\FactoryPromotion as filterFactoryPromotionModel
};
//
use thread\actions\{
    Create,
    ListModel,
    AttributeSwitch,
    Update
};
use yii\web\NotFoundHttpException;

/**
 * Class FactoryPromotionController
 *
 * @package frontend\modules\catalog\controllers
 */
class FactoryPromotionController extends BaseController
{
    public $title = '';

    public $defaultAction = 'list';

    protected $model = FactoryPromotion::class;
    protected $filterModel = filterFactoryPromotionModel::class;

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
                        'roles' => ['factory'],
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
        $this->title = Yii::t('app', 'Рекламная компания');

        return ArrayHelper::merge(
            parent::actions(),
            [
                'list' => [
                    'class' => ListModel::class,
                    'modelClass' => $this->model,
                    'filterModel' => $this->filterModel,
                ],
//                'create' => [
//                    'class' => Create::class,
//                    'modelClass' => $this->model,
//                    'scenario' => 'frontend',
//                    'redirect' => function () {
//                        return ['update', 'id' => $this->action->getModel()->id];
//                    }
//                ],
//                'update' => [
//                    'class' => Update::class,
//                    'modelClass' => $this->model,
//                    'scenario' => 'frontend',
//                    'redirect' => function () {
//                        return ['update', 'id' => $this->action->getModel()->id];
//                    }
//                ],
                'intrash' => [
                    'class' => AttributeSwitch::class,
                    'modelClass' => $this->model,
                    'attribute' => 'deleted',
                    'redirect' => $this->defaultAction,
                ],
            ]
        );
    }

    /**
     *
     */
    public function actionCreate()
    {
        $model = new FactoryPromotion();
        $modelProduct = new FactoryProduct();

        $model->scenario = 'frontend';

        if ($model->isNewRecord) {
            $model->count_of_months = 1;
            $model->daily_budget = 500;
        }

        if ($model->load(Yii::$app->getRequest()->post())) {
            $transaction = $model::getDb()->beginTransaction();
            try {

                $model->user_id = Yii::$app->user->identity->id;
                $model->status = 1;

                $save = $model->save();

                if ($save) {
                    $transaction->commit();

                    return $this->redirect(Url::toRoute(['/catalog/factory-promotion/update', 'id' => $model->id]));
                } else {
                    $transaction->rollBack();
                }
            } catch (Exception $e) {
                $transaction->rollBack();
            }
        }

        return $this->render('_form', [
            'model' => $model,
            'modelProduct' => $modelProduct
        ]);
    }

    /**
     *
     */
    public function actionUpdate($id)
    {
        $model = FactoryPromotion::findById($id);

        /** @var $model FactoryPromotion */

        if ($model == null) {
            throw new NotFoundHttpException(Yii::t('yii', 'Page not found.'));
        }

        $modelProduct = new FactoryProduct();

        $model->scenario = 'frontend';

        if ($model->load(Yii::$app->getRequest()->post())) {
            $transaction = $model::getDb()->beginTransaction();
            try {

                $save = $model->save();

                if ($save) {
                    $transaction->commit();
                } else {
                    $transaction->rollBack();
                }
            } catch (Exception $e) {
                $transaction->rollBack();
            }
        }

        return $this->render('_form', [
            'model' => $model,
            'modelProduct' => $modelProduct
        ]);
    }
}
