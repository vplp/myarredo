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
 * Class PartnerSaleController
 *
 * @package frontend\modules\catalog\controllers
 */
class PartnerSaleController extends BaseController
{
    public $label = "PartnerSale";

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
                    'create' => ['get'],
                    'update' => ['get'],
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
                            'list'
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

        $params = ['user_id' => Yii::$app->getUser()->id];

        $models = $model->partnerSearch(ArrayHelper::merge($params, Yii::$app->request->queryParams));

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
}
