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

        if ($model == null) {
            throw new NotFoundHttpException(Yii::t('yii', 'Page not found.'));
        }

        // ProductStats
        ProductStats::create($model->id);

        $this->breadcrumbs[] = [
            'label' => Yii::t('app','Каталог итальянской мебели'),
            'url' => ['/catalog/category/list']
        ];

        $keys = Yii::$app->catalogFilter->keys;

        if (!$model['is_composition']) {
            $pageTitle[] = $model['lang']['title'];
            $pageDescription[] = $model['lang']['title'];
        }

        if (isset($model['category'][0])) {
            $params = Yii::$app->catalogFilter->params;
            $params[$keys['category']] = $model['category'][0]['alias'];

            if ($model['is_composition']) {
                $pageTitle[] = $model['category'][0]['lang']['composition_title'];
            }

            $this->breadcrumbs[] = [
                'label' => $model['category'][0]['lang']['title'],
                'url' => Yii::$app->catalogFilter->createUrl($params)
            ];
        }

        if (isset($model['types'])) {
            $params = Yii::$app->catalogFilter->params;
            $params[$keys['type']] = $model['types']['alias'];

            if ($model['is_composition']) {
                $pageTitle[] = $model['types']['lang']['title'];
            }

            $this->breadcrumbs[] = [
                'label' => $model['types']['lang']['title'],
                'url' => Yii::$app->catalogFilter->createUrl($params)
            ];
        }

        if ($model['collections_id']) {
            $pageTitle[] = $model['collection']['lang']['title'];
            $pageDescription[] = Yii::t('app','Коллекция: ') . $model['collection']['lang']['title'];
        }

        $array = [];
        foreach ($model['specificationValue'] as $item) {
            if ($item['specification']['parent_id'] == 9) {
                $array[] = $item['specification']['lang']['title'];
            }
        }

        if (!empty($array)) {
            if ($model['is_composition']) {
                $pageTitle[] = implode(', ', $array);
            }
            $pageDescription[] = 'Стиль: ' . implode(', ', $array);
        }

        $array = [];
        foreach ($model['specificationValue'] as $item) {
            if ($item['specification']['parent_id'] == 2) {
                $array[] = $item['specification']['lang']['title'];
            }
        }

        if (!empty($array)) {
            $pageDescription[] = Yii::t('app','Материал: ') . implode(', ', $array);
        }

        $array = [];
        foreach ($model['specificationValue'] as $item) {
            if ($item['specification']['parent_id'] == 4) {
                $array[] = $item['specification']['lang']['title'] .
                    ': ' .
                    $item['val'] . Yii::t('app',' см');
            }
        }

        if (!empty($array)) {
            $pageDescription[] = implode(', ', $array) . '. ';
        }

        $pageTitle[] = Yii::t('app','Купить в ') . Yii::$app->city->getCityTitleWhere();
        $pageDescription[] = Yii::t('app','Купить в интернет-магазине Myarredo в ') . Yii::$app->city->getCityTitleWhere();

        $this->title = implode('. ', $pageTitle);

        Yii::$app->view->registerMetaTag([
            'name' => 'description',
            'content' => implode('. ', $pageDescription),
        ]);

        return $this->render('view', [
            'model' => $model,
        ]);
    }
}