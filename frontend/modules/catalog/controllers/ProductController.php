<?php

namespace frontend\modules\catalog\controllers;

use Yii;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use frontend\modules\catalog\models\{Factory, Product, ProductJson, ProductStats, ProductStatsDays};
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
                    $model = Product::findByAlias(Yii::$app->request->get('alias'));
                    return $model != null ? $model['updated_at'] : time();
                },
                'etagSeed' => function ($action, $params) {
                    $model = Product::findByAlias(Yii::$app->request->get('alias'));
                    return ($model != null && $model['lang']) ? serialize([
                        $model['lang']['title'] ?? '',
                        $model['lang']['description'] ?? ''
                    ]) : '';
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
        /** @var $model Product */
        $model = ProductJson::findByAlias($alias);

        if ($model == null) {
            $model = Product::findByAlias($alias);
        }

        $session = Yii::$app->session;

        if (!$session->has('order_count_url_visit')) {
            $url = 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
            $session->set('order_first_url_visit', $url);
            $session->set('order_count_url_visit', 1);
        } else if ($session->has('order_count_url_visit')) {
            $count = $session->get('order_count_url_visit');
            $session->set('order_count_url_visit', ++$count);
        }

        if ($model == null) {
            $model = Product::find()
                ->innerJoinWith(['factory'])
                ->andFilterWhere([
                    Product::tableName() . '.removed' => '0',
                    Factory::tableName() . '.published' => '1',
                    Factory::tableName() . '.deleted' => '0'
                ])
                ->andFilterWhere([
                    'OR',
                    [Product::tableName() . '.alias' => $alias],
                    [Product::tableName() . '.alias_en' => $alias],
                    [Product::tableName() . '.alias_it' => $alias],
                    [Product::tableName() . '.alias_de' => $alias],
                    [Product::tableName() . '.alias_fr' => $alias],
                    [Product::tableName() . '.alias_he' => $alias],
                ])
                ->enabled()
                ->one();

            if ($model != null && $model['alias'] == $alias) {
                Yii::$app->response->redirect('https://' . 'www.myarredo.ru/product/' . $alias . '/', 301);
                yii::$app->end();
            } elseif ($model != null && $model['alias_en'] == $alias) {
                Yii::$app->response->redirect('https://' . 'www.myarredo.com/en/product/' . $alias . '/', 301);
                yii::$app->end();
            } elseif ($model != null && $model['alias_it'] == $alias) {
                Yii::$app->response->redirect('https://' . 'www.myarredo.com/it/product/' . $alias . '/', 301);
                yii::$app->end();
            } elseif ($model != null && $model['alias_de'] == $alias) {
                Yii::$app->response->redirect('https://' . 'www.myarredo.de/product/' . $alias . '/', 301);
                yii::$app->end();
            } elseif ($model != null && $model['alias_fr'] == $alias) {
                Yii::$app->response->redirect('https://' . 'www.myarredo.fr/product/' . $alias . '/', 301);
                yii::$app->end();
            } elseif ($model != null && $model['alias_he'] == $alias) {
                Yii::$app->response->redirect('https://' . 'www.myarredo.co.il/product/' . $alias . '/', 301);
                yii::$app->end();
            }

            throw new NotFoundHttpException(Yii::t('yii', 'Page not found.'));
        }

        // ProductStats
        ProductStats::create($model->id);

        $this->breadcrumbs[] = [
            'label' => Yii::t('app', 'Каталог итальянской мебели'),
            'url' => ['/catalog/category/list']
        ];

        $keys = Yii::$app->catalogFilter->keys;

        //if (!$model['is_composition']) {
            $pageTitle[] = $model->lang->title;
            $pageDescription[] = $model->lang->title;
        //}

        if (isset($model->category[0])) {
            $params = Yii::$app->catalogFilter->params;

            $params[$keys['category']] = $model->category[0]->{Yii::$app->languages->getDomainAlias()};

            if ($model->is_composition && $model->category[0]->lang->composition_title) {
                $pageTitle[] = $model->category[0]->lang->composition_title;
            }

            $this->breadcrumbs[] = [
                'label' => $model->category[0]->lang->title,
                'url' => Yii::$app->catalogFilter->createUrl($params)
            ];
        }

        if (!empty($model->types)) {
            $params = Yii::$app->catalogFilter->params;
            $params[$keys['type']] = $model->types->{Yii::$app->languages->getDomainAlias()};

            if ($model->is_composition) {
                $pageTitle[] = $model->types->lang->title;
            }

            $this->breadcrumbs[] = [
                'label' => $model->types->lang->title,
                'url' => Yii::$app->catalogFilter->createUrl($params)
            ];
        }

        if ($model->collections_id && !empty($model->collection)) {
            $pageTitle[] = $model->collection->title;
            $pageDescription[] = Yii::t('app', 'Коллекция') . ': ' . $model->collection->title;
        }

        $array = [];
        foreach ($model->specificationValue as $item) {
            if ($item->specification->parent_id == 9) {
                $array[] = $item->specification->lang->title;
            }
        }

        if (!empty($array)) {
            if ($model->is_composition) {
                $pageTitle[] = implode(', ', $array);
            }
            $pageDescription[] = Yii::t('app', 'Стиль') . ': ' . implode(', ', $array);
        }

        $array = [];
        foreach ($model->specificationValue as $item) {
            if ($item->specification->parent_id == 2) {
                $array[] = $item->specification->lang->title;
            }
        }

        if (!empty($array)) {
            $pageDescription[] = Yii::t('app', 'Материал') . ': ' . implode(', ', $array);
        }

        $array = [];
        foreach ($model->specificationValue as $item) {
            if ($item->specification->parent_id == 4) {
                $array[] = $item->specification->lang->title .
                    ': ' .
                    $item->val . Yii::t('app', 'см');
            }
        }

        if (!empty($array)) {
            $pageDescription[] = implode(', ', $array);
        }

        if (DOMAIN_TYPE != 'com') {
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


        if (in_array(DOMAIN_TYPE, ['com']) && DOMAIN_NAME == 'myarredofamily') {
            $hrefCanonical = Yii::$app->request->hostInfo . '/' . Yii::$app->request->pathInfo;
        } elseif (in_array(DOMAIN_TYPE, ['de', 'fr', 'co.il'])) {
            $hrefCanonical = Yii::$app->request->hostInfo . '/' . Yii::$app->request->pathInfo;
        } else {
            $hrefCanonical = Yii::$app->request->hostInfo . ($lang != 'ru' ? '/' . $lang . '/' : '/' ) . Yii::$app->request->pathInfo;
        }

        Yii::$app->view->registerLinkTag([
            'rel' => 'canonical',
            'href' => $hrefCanonical
        ]);

        Yii::$app->metatag->renderArrayGraph([
            'site_name' => 'Myarredo Family',
            'type' => 'product',
            'title' => $pageTitle,
            'description' => $pageDescription,
            'image' => Product::getImage($model->image_link),
        ]);

        /**
         * Viewed products
         */
        if ($model !== null) {
            Yii::$app->getModule('catalog')->getViewedProducts($model->id, 'viewed_products');
        }

        if (in_array(Yii::$app->city->getCityId(), [4, 159, 160, 161, 162, 164, 165])) {
            $alternatePages = [
                'ru' => [
                    'href' => 'https://www.myarredo.ru/product/' . $model->alias . '/', 'lang' => 'ru'
                ],
                'en' => [
                    'href' => 'https://www.myarredo.com/en/product/' . $model->alias_en . '/', 'lang' => 'en'
                ],
                'it' => [
                    'href' => 'https://www.myarredo.com/it/product/' . $model->alias_it . '/', 'lang' => 'it'
                ],
                'de' => [
                    'href' => 'https://www.myarredo.de/product/' . $model->alias_de . '/', 'lang' => 'de'
                ],
                'fr' => [
                    'href' => 'https://www.myarredo.fr/product/' . $model->alias_fr . '/', 'lang' => 'fr'
                ],
                'he' => [
                    'href' => 'https://www.myarredo.co.il/product/' . $model->alias_he . '/', 'lang' => 'he'
                ]
            ];

            foreach ($alternatePages as $page) {
                Yii::$app->view->registerLinkTag([
                    'rel' => 'alternate',
                    'href' => $page['href'],
                    'hreflang' => $page['lang']
                ]);
            }
        }

        $bestsellers = ProductStatsDays::find()
            ->select([
                ProductStatsDays::tableName() . '.product_id',
                'count(' . ProductStatsDays::tableName() . '.product_id) as count',
                'sum(' . ProductStatsDays::tableName() . '.views) as views'
            ])
            ->groupBy(ProductStatsDays::tableName() . '.product_id')
            ->orderBy(['views' => SORT_DESC])
            ->asArray()
            ->limit(30)
            ->cache(7200)
            ->all();

        return $this->render('view', [
            'model' => $model,
            'bestsellers' => ArrayHelper::map($bestsellers, 'product_id', 'product_id'),
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
                    'elementsComposition' => Product::getElementsComposition($model),
                    'samples' => $model->samples
                ]);
            }

            return ['success' => 1, 'html' => $html];
        }
    }
}
