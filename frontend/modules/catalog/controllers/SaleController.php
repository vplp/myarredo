<?php

namespace frontend\modules\catalog\controllers;

use Yii;
use yii\helpers\{
    ArrayHelper, Html
};
use yii\web\Response;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use frontend\components\BaseController;
use frontend\modules\user\models\Profile;
use frontend\modules\catalog\models\{Sale,
    SaleLang,
    SaleRelSpecification,
    SaleStats,
    SalePhoneRequest,
    search\Sale as filterSaleModel,
    Category,
    Factory,
    Types,
    SubTypes,
    Specification,
    Colors
};
use frontend\modules\catalog\widgets\filter\{
    SaleFilter, ProductFilterSizes
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
        $behaviors = [
            [
                'class' => VerbFilter::class,
                'actions' => [
                    'list' => ['get'],
                    'view' => ['post', 'get'],
                    'ajax-get-phone' => ['post'],
                    'ajax-get-filter' => ['post'],
                    'ajax-get-filter-sizes' => ['post'],
                ],
            ]
        ];

        if (Yii::$app->getUser()->isGuest) {
            $behaviors[] = [
                'class' => \yii\filters\HttpCache::class,
                'only' => ['list'],
                'cacheControlHeader' => 'must-revalidate, max-age=86400',
                'lastModified' => function ($action, $params) {
                    $model = Sale::findLastUpdated();
                    return $model != null ? $model['updated_at'] : time();
                },
                'etagSeed' => function ($action, $params) {
                    $model = Sale::findLastUpdated();
                    return serialize([
                        $model->getTitle(),
                        $model->getDescription()
                    ]);
                },
            ];
            $behaviors[] = [
                'class' => \yii\filters\HttpCache::class,
                'only' => ['view'],
                'cacheControlHeader' => 'must-revalidate, max-age=86400',
                'lastModified' => function ($action, $params) {
                    $model = Sale::findByAlias(Yii::$app->request->get('alias'));
                    return $model != null ? $model['updated_at'] : time();
                },
                'etagSeed' => function ($action, $params) {
                    $model = Sale::findByAlias(Yii::$app->request->get('alias'));
                    return serialize([
                        $model->getTitle(),
                        $model->getDescription()
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
        $model = new Sale();

        Yii::$app->catalogFilter->parserUrl();

        $queryParams = Yii::$app->catalogFilter->params;

        $queryParams['country'] = Yii::$app->city->getCountryId();

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
        $model = Sale::findByAlias($alias);

        if ($model == null) {
            throw new NotFoundHttpException(Yii::t('yii', 'Page not found.'));
        }

        if ($model['country_id'] != Yii::$app->city->getCountryId()) {
            throw new NotFoundHttpException(Yii::t('yii', 'Page not found.'));
        }

        // SaleStats
        SaleStats::create($model->id);

        $this->breadcrumbs[] = [
            'label' => Yii::t('app', 'Распродажа итальянской мебели'),
            'url' => ['/catalog/sale/list']
        ];

        $keys = Yii::$app->catalogFilter->keys;

        if (isset($model['category'][0])) {
            $params = Yii::$app->catalogFilter->params;
            $params[$keys['category']] = $model['category'][0][Yii::$app->languages->getDomainAlias()];

            $this->breadcrumbs[] = [
                'label' => $model['category'][0]['lang']['title'],
                'url' => Yii::$app->catalogFilter->createUrl($params, ['/catalog/sale/list'])
            ];
        }

        if (isset($model['types'])) {
            $params = Yii::$app->catalogFilter->params;
            $params[$keys['type']] = $model['types']['alias'];

            $this->breadcrumbs[] = [
                'label' => $model['types']['lang']['title'],
                'url' => Yii::$app->catalogFilter->createUrl($params, ['/catalog/sale/list'])
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

        $pageTitle = implode('. ', $pageTitle);
        $pageDescription = implode('. ', $pageDescription);


        $this->title = $pageTitle;

        Yii::$app->view->registerMetaTag([
            'name' => 'description',
            'content' => $pageDescription,
        ]);

        Yii::$app->metatag->renderArrayGraph([
            'site_name' => 'Myarredo Family',
            'type' => 'article',
            'title' => $pageTitle,
            'description' => $pageDescription,
            'image' => Sale::getImage($model['image_link']),
        ]);

        /**
         * Viewed products
         */
        if ($model !== null) {
            Yii::$app->getModule('catalog')->getViewedProducts($model['id'], 'viewed_sale');
        }

        return $this->render('view', [
            'model' => $model,
        ]);
    }

    /**
     * Get cities
     */
    public function actionAjaxGetPhone()
    {
        if (Yii::$app->request->isAjax) {
            Yii::$app->getResponse()->format = Response::FORMAT_JSON;

            $user_id = Yii::$app->getRequest()->post('user_id');
            $sale_item_id = Yii::$app->getRequest()->post('sale_item_id');

            $user = Profile::findByUserId($user_id);

            if ($user != null) {
                // SalePhoneRequest
                SalePhoneRequest::create($sale_item_id);

                $user['phone'] = $user['phone'] == '+7 (978) 207-41-44' ? '+7 (985) 999-33-04' : $user['phone'];

                return ['success' => 0, 'phone' => $user['phone']];
            }

            return ['success' => 0, 'phone' => null];
        }
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
                'html' => SaleFilter::widget([
                    'route' => '/catalog/sale/list',
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
                    'modelProductRelSpecificationClass' => SaleRelSpecification::class,
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
            'label' => Yii::t('app', 'Распродажа итальянской мебели'),
            'url' => ['/catalog/sale/list']
        ];

        $noIndexFollow = $indexFollow = 0;
        $pageTitle = $pageH1 = $pageDescription = [];

        /**
         * query
         */
        $pageH1[] = Yii::t('app', 'Распродажа');
        $pageTitle[] = Yii::t('app', 'Распродажа мебели');
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
