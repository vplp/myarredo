<?php

namespace frontend\modules\catalog\controllers;

use Yii;
use yii\helpers\{
    ArrayHelper, Html
};
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
//
use frontend\components\BaseController;
use frontend\modules\location\models\{
    Country, City
};
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

        $keys = Yii::$app->catalogFilter->keys;

        Yii::$app->catalogFilter->parserUrl();

        if (!isset(Yii::$app->catalogFilter->params[$keys['country']])) {
            Yii::$app->catalogFilter->setParam($keys['country'], (Yii::$app->city->domain !== 'test') ? Yii::$app->city->domain : 'ru');
        }

        $category = Category::getWithSale(Yii::$app->catalogFilter->params);
        $types = Types::getWithSale(Yii::$app->catalogFilter->params);
        $style = Specification::getWithSale(Yii::$app->catalogFilter->params);
        $factory = Factory::getWithSale(Yii::$app->catalogFilter->params);

        $countries = Country::getWithSale(Yii::$app->catalogFilter->params);
        $cities = City::getWithSale(Yii::$app->catalogFilter->params);

        $models = $model->search(ArrayHelper::merge(Yii::$app->request->queryParams, Yii::$app->catalogFilter->params));

        Yii::$app->metatag->render();

        $this->title = Yii::$app->metatag->seo_title
            ? Yii::$app->metatag->seo_title
            : Yii::t('app','Распродажа итальянской мебели');

        $this->breadcrumbs[] = [
            'label' => Yii::t('app','Распродажа итальянской мебели'),
            'url' => ['/catalog/sale/list']
        ];

        return $this->render('list', [
            'category' => $category,
            'types' => $types,
            'style' => $style,
            'factory' => $factory,
            'countries' => $countries,
            'cities' => $cities,
            'models' => $models->getModels(),
            'pages' => $models->getPagination()
        ]);
    }

    /**
     * @param string $alias
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionView(string $alias)
    {
        $model = Sale::findByAlias($alias);

        if ($model == null) {
            throw new NotFoundHttpException(Yii::t('yii', 'Page not found.'));
        }

        $this->breadcrumbs[] = [
            'label' => Yii::t('app','Каталог итальянской мебели'),
            'url' => ['/catalog/category/list']
        ];

        $this->title = Yii::t('app', 'Sale') . ': ' .
            $model['lang']['title'] .
            ' - '. $model['price_new'] . ' ' . $model['currency'] .
            ' - '. Yii::t('app','интернет-магазин Myarredo в') . ' ' .
            Yii::$app->city->getCityTitleWhere();

        Yii::$app->view->registerMetaTag([
            'name' => 'description',
            'content' => strip_tags($model['lang']['description']) .
                ' ' . Yii::t('app','Купить в интернет-магазине Myarredo в') . ' ' .
                Yii::$app->city->getCityTitleWhere()
        ]);

        return $this->render('view', [
            'model' => $model,
        ]);
    }
}
