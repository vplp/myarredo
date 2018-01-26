<?php

namespace frontend\modules\catalog\controllers;

use Yii;
use yii\helpers\{
    ArrayHelper, Html
};
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
//
use frontend\components\BaseController;
use frontend\modules\catalog\models\{
    Sale,
    SaleLang,
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

        Yii::$app->metatag->render();

        return $this->render('list', [
            'category' => $category,
            'types' => $types,
            'style' => $style,
            'factory' => $factory,
            'models' => $models->getModels(),
            'pages' => $models->getPagination()
        ]);
    }

    /**
     * @param string $alias
     * @return string
     */
    public function actionView(string $alias)
    {
        $model = Sale::findByAlias($alias);

        if ($model === null) {
            throw new NotFoundHttpException;
        }

        $this->breadcrumbs[] = [
            'label' => 'Каталог итальянской мебели',
            'url' => ['/catalog/category/list']
        ];

        $this->title = 'Распродажа: ' .
            $model['lang']['title'] .
            ' - '. $model['price_new'] . ' ' . $model['currency'] .
            ' - интернет-магазин Myarredo в ' .
            Yii::$app->city->getCityTitleWhere();

        Yii::$app->view->registerMetaTag([
            'name' => 'description',
            'content' => strip_tags($model['lang']['description']) .
                ' Купить в интернет-магазине Myarredo в ' .
                Yii::$app->city->getCityTitleWhere()
        ]);

        return $this->render('view', [
            'model' => $model,
        ]);
    }
}
