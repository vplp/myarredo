<?php

namespace frontend\modules\catalog\controllers;

use Yii;
use yii\helpers\ArrayHelper;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
//
use thread\actions\RecordView;
//
use frontend\components\BaseController;
use frontend\modules\catalog\models\{
    Sale,
    SaleLang ,
    search\Sale as filterSaleModel,
    Category,
    Factory,
    Types,
    Specification
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
        ];
    }

    /**
     * @return string
     */
    public function actionList()
    {
        $model = new Sale();

        $category = Category::getWithSale(Yii::$app->catalogFilter->params);
        $types = Types::getWithSale(Yii::$app->catalogFilter->params);
        $style = Specification::getWithSale(Yii::$app->catalogFilter->params);
        $factory = Factory::getWithSale(Yii::$app->catalogFilter->params);

        $models = $model->search(ArrayHelper::merge(Yii::$app->request->queryParams, Yii::$app->catalogFilter->params));

        $this->title = 'Распродажа итальянской мебели';

        $this->breadcrumbs[] = [
            'label' => 'Распродажа итальянской мебели',
            'url' => ['/catalog/sale/list']
        ];

        return $this->render('list', [
            'category' => $category,
            'types' => $types,
            'style' => $style,
            'factory' => $factory,
            'models' => $models->getModels(),
            'pages' => $models->getPagination()
        ]);
    }
}
