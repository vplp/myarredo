<?php

namespace frontend\modules\catalog\controllers;

use Yii;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
//
use thread\actions\RecordView;
//
use frontend\components\BaseController;
use frontend\modules\catalog\models\{
    Sale, SaleLang , search\Sale as filterSaleModel
};
//
use thread\actions\{
    AttributeSwitch, CreateWithLang, ListModel, UpdateWithLang, Delete, Sortable, DeleteAll
};

/**
 * Class SaleController
 *
 * @package frontend\modules\catalog\controllers
 */
class SaleController extends BaseController
{
    public $label = "Sale";

    public $title = "Sale";

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
                    'partner-list' => ['get'],
                    'view' => ['get'],
                ],
            ],
            'AccessControl' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => [
                            'list', 'view'
                        ],
                        'roles' => ['?', '@'],
                    ],
                    [
                        'allow' => true,
                        'actions' => [
                            'create',
                            'update',
                            'partner-list'
                        ],
                        'roles' => ['partner'],
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
            'view' => [
                'class' => RecordView::class,
                'modelClass' => $this->model,
                'methodName' => 'findByAlias',
            ],
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
        ];
    }

    /**
     * @return string
     */
    public function actionList()
    {
        $model = new Sale();

        $params = [];

        $models = $model->search(ArrayHelper::merge($params, Yii::$app->request->queryParams));

        $this->title = 'Распродажа итальянской мебели';

        $this->breadcrumbs[] = [
            'label' => 'Распродажа итальянской мебели',
            'url' => ['/catalog/sale/list']
        ];

        return $this->render('list', [
            'models' => $models->getModels(),
            'pages' => $models->getPagination(),
        ]);
    }

    /**
     * @return string
     */
    public function actionPartnerList()
    {
        $model = new Sale();

        $params = ['user_id' => Yii::$app->getUser()->id];

        $models = $model->search(ArrayHelper::merge($params, Yii::$app->request->queryParams));

        $this->title = 'Распродажа итальянской мебели';

        $this->breadcrumbs[] = [
            'label' => 'Распродажа итальянской мебели',
            'url' => ['/catalog/sale/list']
        ];

        return $this->render('partner_list', [
            'models' => $models->getModels(),
            'pages' => $models->getPagination(),
        ]);
    }
}
