<?php

namespace frontend\modules\catalog\controllers;

use Yii;
use yii\helpers\{
    ArrayHelper
};
use yii\web\Response;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use frontend\components\BaseController;
use frontend\modules\catalog\models\{ItalianProduct,
    ItalianProductLang,
    ItalianProductRelSpecification,
    search\ItalianProduct as filterItalianProductModel,
    ItalianProductStats,
    Category,
    Factory,
    Types,
    SubTypes,
    Specification,
    Colors
};
use frontend\modules\catalog\widgets\filter\{
    ItalianProductFilter, ProductFilterSizes
};

/**
 * Class SaleItalyController
 *
 * @package frontend\modules\catalog\controllers
 */
class SaleItalyController extends BaseController
{
    public $label = "Sale in Italy";

    public $title = "Sale in Italy";

    public $defaultAction = 'list';

    protected $model = ItalianProduct::class;

    protected $modelLang = ItalianProductLang::class;

    protected $filterModel = filterItalianProductModel::class;

    /**
     * @param \yii\base\Action $action
     * @return bool
     * @throws \yii\base\ExitException
     * @throws \yii\web\BadRequestHttpException
     */
    public function beforeAction($action)
    {
        $this->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }

    /**
     * @return array
     */
    public function behaviors()
    {
        $behaviors = [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'list' => ['get'],
                    'view' => ['post', 'get'],
                    'ajax-get-filter' => ['post'],
                    'ajax-get-filter-sizes' => ['post'],
                ],
            ],
        ];

        if (Yii::$app->getUser()->isGuest) {
            $behaviors[] = [
                'class' => \yii\filters\HttpCache::class,
                'only' => ['list'],
                'cacheControlHeader' => 'must-revalidate, max-age=86400',
                'lastModified' => function ($action, $params) {
                    $model = ItalianProduct::findLastUpdated();
                    return $model['updated_at'];
                },
                'etagSeed' => function ($action, $params) {
                    $model = ItalianProduct::findLastUpdated();
                    return serialize([
                        $model['lang']['title'],
                        $model['lang']['description']
                    ]);
                },
            ];

            $behaviors[] = [
                'class' => \yii\filters\HttpCache::class,
                'only' => ['view'],
                'cacheControlHeader' => 'must-revalidate, max-age=86400',
                'lastModified' => function ($action, $params) {
                    $model = ItalianProduct::findByAlias(Yii::$app->request->get('alias'));
                    return $model['updated_at'];
                },
                'etagSeed' => function ($action, $params) {
                    $model = ItalianProduct::findByAlias(Yii::$app->request->get('alias'));
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
     * @return string
     * @throws \Throwable
     * @throws \yii\base\InvalidConfigException
     */
    public function actionList()
    {
        $model = new ItalianProduct();

        Yii::$app->catalogFilter->parserUrl();

        $queryParams = Yii::$app->catalogFilter->params;

        $queryParams['defaultPageSize'] = 33;
        $models = $model->search(ArrayHelper::merge(Yii::$app->request->queryParams, $queryParams));

        Yii::$app->metatag
            ->render()
            ->setImageUrl('https://img.' . DOMAIN_NAME . '.' . DOMAIN_TYPE . '/uploads/myarredo-ico.jpg')
            ->renderGraph();

        if (!empty($models->getModels())) {
            $this->listSeo();
        } else {
            Yii::$app->view->registerMetaTag([
                'name' => 'robots',
                'content' => 'noindex, follow',
            ]);
        }

        return $this->render('list', [
            'models' => $models->getModels(),
            'pages' => $models->getPagination()
        ]);
    }

    /**
     * @param string $alias
     * @return string
     * @throws NotFoundHttpException
     * @throws \Throwable
     * @throws \yii\base\InvalidConfigException
     */
    public function actionView(string $alias)
    {
        $model = ItalianProduct::findByAlias($alias);

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
            $model = ItalianProduct::find()
                ->andFilterWhere([
                    'OR',
                    [ItalianProduct::tableName() . '.alias' => $alias],
                    [ItalianProduct::tableName() . '.alias_en' => $alias],
                    [ItalianProduct::tableName() . '.alias_it' => $alias],
                    [ItalianProduct::tableName() . '.alias_de' => $alias],
                ])
                ->enabled()
                ->one();

            if ($model != null && $model['alias'] == $alias) {
                Yii::$app->response->redirect('https://' . 'www.myarredo.ru/sale-italy-product/' . $alias . '/', 301);
                yii::$app->end();
            } elseif ($model != null && $model['alias_en'] == $alias) {
                Yii::$app->response->redirect('https://' . 'www.myarredo.com/en/sale-italy-product/' . $alias . '/', 301);
                yii::$app->end();
            } elseif ($model != null && $model['alias_it'] == $alias) {
                Yii::$app->response->redirect('https://' . 'www.myarredo.com/it/sale-italy-product/' . $alias . '/', 301);
                yii::$app->end();
            } elseif ($model != null && $model['alias_de'] == $alias) {
                Yii::$app->response->redirect('https://' . 'www.myarredo.de/sale-italy-product/' . $alias . '/', 301);
                yii::$app->end();
            }

            throw new NotFoundHttpException(Yii::t('yii', 'Page not found.'));
        }

        // ItalianProductStats
        ItalianProductStats::create($model['id']);

        $this->breadcrumbs[] = [
            'label' => Yii::t('app', 'Sale in Italy'),
            'url' => ['/catalog/sale-italy/list']
        ];

        $keys = Yii::$app->catalogFilter->keys;

        if (isset($model['category'][0])) {
            $params = Yii::$app->catalogFilter->params;
            $params[$keys['category']] = $model['category'][0][Yii::$app->languages->getDomainAlias()];

            $this->breadcrumbs[] = [
                'label' => $model['category'][0]['lang']['title'],
                'url' => Yii::$app->catalogFilter->createUrl($params, ['/catalog/sale-italy/list'])
            ];
        }

        if (isset($model['types'])) {
            $params = Yii::$app->catalogFilter->params;
            $params[$keys['type']] = $model['types']['alias'];

            $this->breadcrumbs[] = [
                'label' => $model['types']['lang']['title'],
                'url' => Yii::$app->catalogFilter->createUrl($params, ['/catalog/sale-italy/list'])
            ];
        }

        $pageTitle[] = Yii::t('app', 'Sale') . ' ' .
            $model['lang']['title'] . ' ' .
            Yii::t('app', 'в наличии') .
            (DOMAIN_TYPE != 'com' ? ' ' . Yii::$app->city->getCityTitle() : '') . ' MyArredo';

        $pageDescription[] = Yii::t('app', 'Купить') . ' ' .
            $model['lang']['title'] . ' ' .
            Yii::t('app', 'со скидкой на распродаже') .
            (DOMAIN_TYPE != 'com' ? ' ' . Yii::$app->city->getCityTitle() : '') . ' MyArredo';

        // [Товар из ХК]
        $array = [];
        foreach ($model['specificationValue'] as $item) {
            if ($item['specification']['parent_id'] == 2) {
                $array[] = $item['specification']['lang']['title'];
            }
        }

        foreach ($model['specificationValue'] as $item) {
            if ($item['specification']['parent_id'] == 4) {
                $array[] = $item['specification']['lang']['title'] .
                    ': ' .
                    $item['val'] . Yii::t('app', 'см');
            }
        }

        if (!empty($array)) {
            $pageTitle[] = implode(', ', $array);

            $pageDescription[] = Yii::t('app', 'Воспользуйтесь возможностью приобрести') . ' ' .
                implode(', ', $array) . ', ' .
                Yii::t('app', 'из Италии с экспозиции в салонах-партнерах MyArredo - портал проверенных поставщиков итальянской мебели');
        }

        // Стиль
        $array = [];
        foreach ($model['specificationValue'] as $item) {
            if ($item['specification']['parent_id'] == 9) {
                $array[] = $item['specification']['lang']['title'];
            }
        }

        if (!empty($array)) {
            $pageTitle[] = Yii::t('app', 'Стиль') . ': ' .
                implode(', ', $array) . ' ' .
                Yii::t('app', 'из Италии со скидкой');
        }

        $this->title = implode('. ', $pageTitle);

        Yii::$app->view->registerMetaTag([
            'name' => 'description',
            'content' => implode('. ', $pageDescription),
        ]);

        /**
         * Viewed products
         */
        if ($model !== null) {
            Yii::$app->getModule('catalog')->getViewedProducts($model['id'], 'viewed_sale_italy');
        }

        if (in_array(Yii::$app->city->getCityId(), [4, 159, 160, 161, 164])) {
            $alternatePages = [
                'ru' => [
                    'href' => 'https://www.myarredo.ru/sale-italy-product/' . $model['alias'] . '/', 'lang' => 'ru'
                ],
                'en' => [
                    'href' => 'https://www.myarredo.com/en/sale-italy-product/' . $model['alias_en'] . '/', 'lang' => 'en'
                ],
                'it' => [
                    'href' => 'https://www.myarredo.com/it/sale-italy-product/' . $model['alias_it'] . '/', 'lang' => 'it'
                ],
                'de' => [
                    'href' => 'https://www.myarredo.de/sale-italy-product/' . $model['alias_de'] . '/', 'lang' => 'de'
                ],
                'he' => [
                    'href' => 'https://www.myarredo.co.il/sale-italy-product/' . $model['alias_en'] . '/', 'lang' => 'he'
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

        return $this->render('view', [
            'model' => $model,
        ]);
    }

    /**
     * @return array
     * @throws \Exception
     */
    public function actionAjaxGetFilter()
    {
        if (Yii::$app->request->isAjax) {
            Yii::$app->getResponse()->format = Response::FORMAT_JSON;

            return [
                'success' => 1,
                'html' => ItalianProductFilter::widget([
                    'route' => '/catalog/sale-italy/list',
                    'catalogFilterParams' => Yii::$app->getRequest()->post('catalogFilterParams')
                ])
            ];
        }
    }

    /**
     * @return array
     * @throws \Exception
     */
    public function actionAjaxGetFilterSizes()
    {
        if (Yii::$app->request->isAjax) {
            Yii::$app->getResponse()->format = Response::FORMAT_JSON;

            return [
                'success' => 1,
                'html' => ProductFilterSizes::widget([
                    'modelProductRelSpecificationClass' => ItalianProductRelSpecification::class,
                    'route' => Yii::$app->getRequest()->post('link'),
                    'catalogFilterParams' => Yii::$app->getRequest()->post('catalogFilterParams')
                ])
            ];
        }
    }

    /**
     * @inheritdoc
     */
    public function listSeo()
    {
        $keys = Yii::$app->catalogFilter->keys;
        $params = Yii::$app->catalogFilter->params;

        $this->breadcrumbs[] = [
            'label' => Yii::t('app', 'Sale in Italy'),
            'url' => ['/catalog/sale-italy/list']
        ];

        $noIndexFollow = $indexFollow = 0;
        $pageTitle = $pageH1 = $pageDescription = [];

        /**
         * query
         */
        $pageH1[] = Yii::t('app', 'Распродажа');
        $pageTitle[] = Yii::t('app', 'Sale in Italy');
        $pageDescription[] = Yii::t('app', 'Распродажа');

        if (!empty($params[$keys['category']])) {
            $model = Category::findByAlias($params[$keys['category']][0]);

            $pageH1[] = $model['lang']['title'];
            $pageTitle[] = $model['lang']['title'];
            $pageDescription[] = $model['lang']['title'];

            $this->breadcrumbs[] = [
                'label' => $model['lang']['title'],
                'url' => Yii::$app->catalogFilter->createUrl([$keys['category'] => $params[$keys['category']]])
            ];
        } else {
            $pageH1[] = Yii::t('app', 'мебели');
            $pageDescription[] = Yii::t('app', 'мебели');
        }

        if (!empty($params[$keys['factory']])) {
            $models = Factory::findAllByAlias($params[$keys['factory']]);

            $factory = [];
            foreach ($models as $model) {
                $factory[] = $model['title'];
            }

            if (count($params[$keys['factory']]) > 1) {
                $noIndexFollow = 1;
            }

            if (count($params) == 1 && count($params[$keys['factory']]) == 1) {
                $indexFollow = 1;
            }

            $pageTitle[] = implode(', ', $factory);
            $pageH1[] = implode(', ', $factory);
            $pageDescription[] = implode(', ', $factory);

            $this->breadcrumbs[] = [
                'label' => implode(', ', $factory),
                'url' => Yii::$app->catalogFilter->createUrl([$keys['factory'] => $params[$keys['factory']]])
            ];
        }

        $countParams = 0;
        foreach ($params as $arr) {
            $countParams += count($arr);
        }

        if ($countParams > 3) {
            $this->noIndex = 1;
        }

        /**
         * set options
         */

        $pageTitle[] = Yii::t('app', 'из Италии в наличии') .
            (DOMAIN_TYPE != 'com' ? ' ' . Yii::$app->city->getCityTitle() : '') . ' | ' .
            Yii::t('app', 'MyArredo итальянская мебель со скидками');

        $pageDescription[] = Yii::t('app', 'со скидкой') .
            (DOMAIN_TYPE != 'com' ? ' ' . Yii::$app->city->getCityTitle() : '') . '. ' .
            Yii::t(
                'app',
                'Воспользуйтесь возможностью приобрести мебель из Италии с экспозиции в салонах-партнерах Myarredo - портал проверенных поставщиков итальянской мебели.'
            );

        $this->title = Yii::$app->metatag->seo_title
            ? Yii::$app->metatag->seo_title
            : (!empty($pageTitle)
                ? implode(' ', $pageTitle)
                : Yii::t('app', 'Распродажа итальянской мебели'));

        if (!Yii::$app->metatag->seo_description) {
            Yii::$app->view->registerMetaTag([
                'name' => 'description',
                'content' => implode(' ', $pageDescription),
            ]);
        }

        if ($noIndexFollow) {
            Yii::$app->view->registerMetaTag([
                'name' => 'robots',
                'content' => 'noindex, follow',
            ]);
        } elseif ($indexFollow) {
            Yii::$app->view->registerMetaTag([
                'name' => 'robots',
                'content' => 'index, follow',
            ]);
        }

        Yii::$app->metatag->seo_h1 = (Yii::$app->metatag->seo_h1 != '')
            ? Yii::$app->metatag->seo_h1
            : implode(', ', $pageH1);

        return $this;
    }
}
