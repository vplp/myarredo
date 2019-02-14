<?php

namespace frontend\modules\catalog\controllers;

use Yii;
use yii\helpers\{
    ArrayHelper, Html
};
use yii\web\Response;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
//
use frontend\components\BaseController;
use frontend\modules\location\models\{
    Country, City
};
use frontend\modules\user\models\Profile;
use frontend\modules\catalog\models\{
    Sale, SaleLang, SaleStats, SalePhoneRequest, search\Sale as filterSaleModel, Category, Factory, Types, Specification
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
                    'view' => ['post', 'get'],
                    'ajax-get-phone' => ['post'],
                ],
            ],
            'AccessControl' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => [
                            'list',
                            'view',
                            'ajax-get-phone'
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
     * @throws \Throwable
     * @throws \yii\base\InvalidConfigException
     */
    public function actionList()
    {
        $model = new Sale();

        Yii::$app->catalogFilter->parserUrl();

        $queryParams = Yii::$app->catalogFilter->params;

        $queryParams['country'] = Yii::$app->city->getCountryId();
        $queryParams['city'] = Yii::$app->city->getCityId();

        $category = Category::getWithSale($queryParams);
        $types = Types::getWithSale($queryParams);
        $style = Specification::getWithSale($queryParams);
        $factory = Factory::getWithSale($queryParams);
        $countries = Country::getWithSale($queryParams);
        $cities = City::getWithSale($queryParams);

        $models = $model->search(ArrayHelper::merge(Yii::$app->request->queryParams, $queryParams));

        Yii::$app->metatag->render();

        if (!empty($models->getModels())) {
            $this->listSeo();
        } else {
            Yii::$app->view->registerMetaTag([
                'name' => 'robots',
                'content' => 'noindex, follow',
            ]);
        }

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

        // SaleStats
        SaleStats::create($model->id);

        $this->breadcrumbs[] = [
            'label' => Yii::t('app', 'Распродажа итальянской мебели'),
            'url' => ['/catalog/sale/list']
        ];

        $keys = Yii::$app->catalogFilter->keys;

        if (isset($model['category'][0])) {
            $params = Yii::$app->catalogFilter->params;
            $params[$keys['category']] = $model['category'][0]['alias'];

            $this->breadcrumbs[] = [
                'label' => $model['category'][0]['lang']['title'],
                'url' => Yii::$app->catalogFilter->createUrl($params, '/catalog/sale/list')
            ];
        }

        if (isset($model['types'])) {
            $params = Yii::$app->catalogFilter->params;
            $params[$keys['type']] = $model['types']['alias'];

            $this->breadcrumbs[] = [
                'label' => $model['types']['lang']['title'],
                'url' => Yii::$app->catalogFilter->createUrl($params, '/catalog/sale/list')
            ];
        }

        $pageTitle[] = Yii::t('app', 'Sale') . ' ' .
            $model['lang']['title'] . ' ' .
            Yii::t('app', 'в наличии') . ' ' .
            Yii::$app->city->getCityTitle() . ' MyArredo';

        $pageDescription[] = Yii::t('app', 'Купить') . ' ' .
            $model['lang']['title'] . ' ' .
            Yii::t('app', 'со скидкой на распродаже') . ' ' .
            Yii::$app->city->getCityTitle() . ' MyArredo';

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

                return ['success' => 0, 'phone' => $user['phone']];
            }

            return ['success' => 0, 'phone' => null];
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

        if (count($params) > 3) {
            $noIndexFollow = 1;
        }

        /**
         * set options
         */

        $pageTitle[] = Yii::t('app', 'из Италии в наличии') . ' ' .
            Yii::$app->city->getCityTitle() . ' | ' .
            Yii::t('app', 'MyArredo итальянская мебель со скидками');

        $pageDescription[] = Yii::t('app', 'со скидкой') . ' ' .
            Yii::$app->city->getCityTitle() . '. ' .
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

        $this->pageH1 = ($this->pageH1 != '')
            ? $this->pageH1
            : implode(' ', $pageH1);

        return $this;
    }
}
