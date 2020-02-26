<?php

namespace frontend\modules\catalog\controllers;

use Yii;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;
use yii\web\Response;
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
        $behaviors = [
            [
                'class' => VerbFilter::class,
                'actions' => [
                    'view' => ['get'],
                    'ajax-get-compositions' => ['get', 'post'],
                ],
            ],
        ];

        if (Yii::$app->getUser()->isGuest) {
            $behaviors[] = [
                'class' => \yii\filters\HttpCache::class,
                'only' => ['view'],
                'cacheControlHeader' => 'must-revalidate, max-age=86400',
                'lastModified' => function ($action, $params) {
                    return Product::findBase()
                        ->byAlias(Yii::$app->request->get('alias'))
                        ->max(Product::tableName() . '.updated_at');
                },
                'etagSeed' => function ($action, $params) {
                    $model = Product::findByAlias(Yii::$app->request->get('alias'));
                    return serialize([
                        $model['lang']['title'],
                        $model['lang']['description']
                    ]);
                },
            ];
        }

        return $behaviors;
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
            'label' => Yii::t('app', 'Каталог итальянской мебели'),
            'url' => ['/catalog/category/list']
        ];

        $keys = Yii::$app->catalogFilter->keys;

        if (!$model['is_composition']) {
            $pageTitle[] = $model['lang']['title'];
            $pageDescription[] = $model['lang']['title'];
        }

        if (isset($model['category'][0])) {
            $params = Yii::$app->catalogFilter->params;

            $params[$keys['category']] = Yii::$app->city->domain != 'com'
                ? $model['category'][0]['alias']
                : $model['category'][0]['alias2'];

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
            $pageTitle[] = $model['collection']['title'];
            $pageDescription[] = Yii::t('app', 'Коллекция') . ': ' . $model['collection']['title'];
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
            $pageDescription[] = Yii::t('app', 'Стиль') . ': ' . implode(', ', $array);
        }

        $array = [];
        foreach ($model['specificationValue'] as $item) {
            if ($item['specification']['parent_id'] == 2) {
                $array[] = $item['specification']['lang']['title'];
            }
        }

        if (!empty($array)) {
            $pageDescription[] = Yii::t('app', 'Материал') . ': ' . implode(', ', $array);
        }

        $array = [];
        foreach ($model['specificationValue'] as $item) {
            if ($item['specification']['parent_id'] == 4) {
                $array[] = $item['specification']['lang']['title'] .
                    ': ' .
                    $item['val'] . Yii::t('app', 'см');
            }
        }

        if (!empty($array)) {
            $pageDescription[] = implode(', ', $array);
        }

        if (Yii::$app->city->domain != 'com') {
            $pageTitle[] = Yii::t('app', 'Купить в') . ' ' . Yii::$app->city->getCityTitleWhere();
            $pageDescription[] = Yii::t('app', 'Купить в интернет-магазине Myarredo в') .
                ' ' . Yii::$app->city->getCityTitleWhere();
        }

        $pageTitle = implode('. ', $pageTitle);
        $pageDescription = implode('. ', $pageDescription);

        $this->title = $pageTitle;

        Yii::$app->view->registerMetaTag([
            'name' => 'description',
            'content' => $pageDescription,
        ]);

        $lang = substr(Yii::$app->language, 0, 2);

        Yii::$app->view->registerLinkTag([
            'rel' => 'canonical',
            'href' => Yii::$app->request->hostInfo . '/' .
                ($lang != 'ru' ? $lang . '/' : '') .
                Yii::$app->request->pathInfo
        ]);

        Yii::$app->metatag->renderArrayGraph([
            'site_name' => 'Myarredo Family',
            'type' => 'article',
            'title' => $pageTitle,
            'description' => $pageDescription,
            'image' => Yii::$app->request->hostInfo . Product::getImage($model['image_link']),
        ]);

        /**
         * Viewed products
         */
        if ($model !== null) {
            Yii::$app->getModule('catalog')->getViewedProducts($model['id'], 'viewed_products');
        }

        return $this->render('view', [
            'model' => $model,
        ]);
    }

    /**
     * @return array
     */
    public function actionAjaxGetCompositions()
    {
        if (Yii::$app->request->isAjax && Yii::$app->getRequest()->post('product_id')) {
            Yii::$app->getResponse()->format = Response::FORMAT_JSON;

            $html = '';

            $model = Product::findBase()->byID(Yii::$app->getRequest()->post('product_id'))->one();
            /** @var $model Product */
            if ($model != null) {
                $html = $this->renderPartial('ajax_get_compositions', [
                    'model' => $model,
                    'elementsComposition' => $model->getElementsComposition(),
                    'samples' => $model->samples
                ]);
            }

            return ['success' => 1, 'html' => $html];
        }
    }
}
