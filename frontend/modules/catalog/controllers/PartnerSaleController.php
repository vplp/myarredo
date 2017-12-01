<?php

namespace frontend\modules\catalog\controllers;

use Yii;
use yii\helpers\ArrayHelper;
use yii\filters\{
    VerbFilter, AccessControl
};
//
use frontend\components\BaseController;
use frontend\modules\catalog\models\{
    Sale, SaleLang , search\Sale as filterSaleModel
};
//
use thread\actions\{
    CreateWithLang, UpdateWithLang
};
//
use common\actions\upload\{
    DeleteAction, UploadAction
};

/**
 * Class PartnerSaleController
 *
 * @package frontend\modules\catalog\controllers
 */
class PartnerSaleController extends BaseController
{
    public $title = "PartnerSale";

    public $defaultAction = 'list';

    protected $model = Sale::class;

    protected $modelLang = SaleLang::class;

    protected $filterModel = filterSaleModel::class;

    /**
     * @return array
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'list' => ['get'],
                    'create' => ['get', 'post'],
                    'update' => ['get', 'post'],
                    'fileupload' => ['post'],
                    'filedelete' => ['post'],
                    'code' => ['get'],
                    'instructions' => ['get'],
                ],
            ],
            'AccessControl' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => [
                            'create',
                            'update',
                            'list',
                            'code',
                            'instructions',
                            'mailing-by-cities',
                            'fileupload',
                            'filedelete'
                        ],
                        'roles' => ['partner', 'admin'],
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
            'create' => [
                'class' => CreateWithLang::class,
                'modelClass' => $this->model,
                'modelClassLang' => $this->modelLang,
                'redirect' => function () {
                    return ['update', 'id' => $this->action->getModel()->id];
                }
            ],
            'update' => [
                'class' => UpdateWithLang::class,
                'modelClass' => $this->model,
                'modelClassLang' => $this->modelLang,
                'redirect' => function () {
                    return ['update', 'id' => $this->action->getModel()->id];
                }
            ],
            'fileupload' => [
                'class' => UploadAction::class,
                'useHashPath' => true,
                'path' => $this->module->getSaleUploadPath()
            ],
            'filedelete' => [
                'class' => DeleteAction::class,
                'useHashPath' => true,
                'path' => $this->module->getSaleUploadPath()
            ],
        ];
    }

    /**
     * @return string
     */
    public function actionList()
    {
        $model = new Sale();

        $params = ['user_id' => Yii::$app->getUser()->id];

        $models = $model->partnerSearch(ArrayHelper::merge($params, Yii::$app->request->queryParams));

        $this->title = 'Моя распродажа';

        $this->breadcrumbs[] = [
            'label' => 'Моя распродажа',
        ];

        return $this->render('list', [
            'models' => $models->getModels(),
            'pages' => $models->getPagination(),
        ]);
    }

    /**
     * @return string
     */
    public function actionCode()
    {
        $this->title = 'Размещение кода';
        return $this->render('code', []);
    }

    /**
     * @return string
     */
    public function actionMailingByCities()
    {
        $this->title = 'Размещение кода';
        return $this->render('mailing_by_cities', []);
    }

    /**
     * @return string
     */
    public function actionInstructions()
    {
        $this->title = 'Инструкция партнерам';
        return $this->render('instructions', ['domain' => 'ru']);
    }
}
