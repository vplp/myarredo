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
                    'create' => ['get', 'post'],
                    'update' => ['get', 'post'],
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
                            'instructions'
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
    public function actionInstructions()
    {
        $this->title = 'Инструкция партнерам';
        return $this->render('instructions', ['domain' => 'ru']);
    }
}
