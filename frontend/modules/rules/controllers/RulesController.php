<?php

namespace frontend\modules\rules\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
//
use frontend\components\BaseController;
use frontend\modules\rules\models\Rules;

/**
 * Class RulesController
 *
 * @package frontend\modules\rules\controllers
 */
class RulesController extends BaseController
{
    public $label = "Rules";

    public $title = "Rules";

    public $defaultAction = 'list';

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
                        'actions' => ['list', 'view'],
                        'roles' => ['partner', 'factory'],
                    ],
                    [
                        'allow' => false,
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'list' => ['get'],
                    'view' => ['get'],
                ],
            ],
        ];
    }

    /**
     * @return string
     */
    public function actionList()
    {
        $models = Rules::findBase()->all();

        $this->title = Yii::t('app', 'General rules');

        return $this->render('list', [
            'models' => $models,
        ]);
    }

    /**
     * @param $id
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionView($id)
    {
        $model = Rules::findById($id);

        if ($model == null) {
            throw new NotFoundHttpException();
        }

        return $this->render('view', [
            'model' => $model,
        ]);
    }
}
