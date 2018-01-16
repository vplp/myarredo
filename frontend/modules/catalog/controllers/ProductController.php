<?php

namespace frontend\modules\catalog\controllers;

use Yii;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;
//
use frontend\modules\catalog\models\{
    Product, ProductStats
};
use frontend\components\BaseController;

/**
 * Class ProductController
 *
 * @package frontend\modules\news\controllers
 */
class ProductController extends BaseController
{
    public $title = "Product";
    public $defaultAction = 'view';

    /**
     * @return array
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'view' => ['get'],
                ],
            ],
        ];
    }

    /**
     * @param string $alias
     * @return string
     * @throws NotFoundHttpException
     * @throws \Exception
     * @throws \Throwable
     */
    public function actionView(string $alias)
    {
        $model = Product::findByAlias($alias);

        if ($model === null) {
            throw new NotFoundHttpException;
        }

        // ProductStats
        ProductStats::create($model->id);

        $this->breadcrumbs[] = [
            'label' => 'Каталог итальянской мебели',
            'url' => ['/catalog/category/list']
        ];

        $keys = Yii::$app->catalogFilter->keys;


        if (isset($model['category'][0])) {
            $params = Yii::$app->catalogFilter->params;
            $params[$keys['category']] = $model['category'][0]['alias'];

            $this->breadcrumbs[] = [
                'label' => $model['category'][0]['lang']['title'],
                'url' => Yii::$app->catalogFilter->createUrl($params)
            ];
        }

        if (isset($model['types'])) {
            $params = Yii::$app->catalogFilter->params;
            $params[$keys['type']] = $model['types']['alias'];

            $this->breadcrumbs[] = [
                'label' => $model['types']['lang']['title'],
                'url' => Yii::$app->catalogFilter->createUrl($params)
            ];
        }

        $this->title = $model['lang']['title'] . '. Купить в ' . Yii::$app->city->getCityTitleWhere();

        $description = $model['lang']['title'] . '. ';

        if ($model['collections_id']) {
            $description .= 'Коллекция: ' . $model['collection']['lang']['title'] . '. ';
        }

        $array = [];
        foreach ($model['specificationValue'] as $item) {
            if ($item['specification']['parent_id'] == 9) {
                $array[] = $item['specification']['lang']['title'];
            }
        }

        if (!empty($array)) {
            $description .= 'Стиль: ' . implode(', ', $array) . '. ';
        }

        $array = [];
        foreach ($model['specificationValue'] as $item) {
            if ($item['specification']['parent_id'] == 2) {
                $array[] = $item['specification']['lang']['title'];
            }
        }

        if (!empty($array)) {
            $description .= 'Материал: ' . implode(', ', $array) . '. ';
        }

        $array = [];
        foreach ($model['specificationValue'] as $item) {
            if ($item['specification']['parent_id'] == 4) {
                $array[] = $item['specification']['lang']['title'] .
                    ': ' .
                    $item['val'] . ' см';
            }
        }

        if (!empty($array)) {
            $description .= implode(', ', $array) . '. ';
        }

        $description .= 'Купить в интернет-магазине Myarredo в ' . Yii::$app->city->getCityTitleWhere();

        Yii::$app->view->registerMetaTag([
            'name' => 'description',
            'content' => $description,
        ]);

        return $this->render('view', [
            'model' => $model,
        ]);
    }
}