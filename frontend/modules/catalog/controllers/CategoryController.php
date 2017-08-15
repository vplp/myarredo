<?php

namespace frontend\modules\catalog\controllers;

use frontend\modules\catalog\widgets\menu\CatalogMenu;
use Yii;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
//
use frontend\components\BaseController;
use frontend\modules\catalog\models\{
    Product, Category, Factory, Types, Specification, Collection
};

/**
 * Class CategoryController
 *
 * @package frontend\modules\catalog\controllers
 */
class CategoryController extends BaseController
{
    public $label = "Category";
    public $title = "Category";
    public $defaultAction = 'list';

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
                ],
            ],
        ];
    }

    /**
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionList()
    {
        $model = new Product();

        $params = $group = [];

        if (isset(Yii::$app->catalogFilter->params['category'])) {
            $group = Yii::$app->catalogFilter->params['category'];
        }

        $category = Category::getAllWithFilter(Yii::$app->catalogFilter->params);
        $types = Types::getAllWithFilter(Yii::$app->catalogFilter->params);
        $style = Specification::getAllWithFilter(Yii::$app->catalogFilter->params);
        $factory = Factory::getAllWithFilter(Yii::$app->catalogFilter->params);
        $collection = Collection::getAllWithFilter(Yii::$app->catalogFilter->params);

        $models = $model->search(ArrayHelper::merge(Yii::$app->request->queryParams, Yii::$app->catalogFilter->params));

        return $this->render('list', [
            'group' => $group,
            'category' => $category,
            'types' => $types,
            'style' => $style,
            'factory' => $factory,
            'collection' => $collection,
            'models' => $models->getModels(),
            'pages' => $models->getPagination(),
        ]);
    }
    public function beforeAction($action)
    {
        $params = Yii::$app->catalogFilter->params;

        $this->title = 'Каталог итальянской мебели';

        $this->breadcrumbs[] = [
            'label' => 'Каталог итальянской мебели',
            'url' => ['/catalog/category/list']
        ];

        if (!empty($params['category'])) {

            $this->breadcrumbs[] = [
                'label' => $params['category']['lang']['title'],
                'url' => Yii::$app->catalogFilter->createUrl('category', $params['category']['alias'], true)
            ];
        }

        if (!empty($params['type'])) {
            $this->breadcrumbs[] = [
                'label' => $params['type']['lang']['title'],
                'url' => Yii::$app->catalogFilter->createUrl('type', $params['type']['alias'], true)
            ];
        }

        if (!empty($params['style'])) {
            $this->breadcrumbs[] = [
                'label' => $params['style']['lang']['title'],
                'url' => Yii::$app->catalogFilter->createUrl('type', $params['style']['alias'], true)
            ];
        }

        if (!empty($params['factory'])) {
            $this->breadcrumbs[] = [
                'label' => $params['factory']['lang']['title'],
                'url' => Yii::$app->catalogFilter->createUrl('type', $params['factory']['alias'], true)
            ];
        }

        return parent::beforeAction($action);
    }
}
