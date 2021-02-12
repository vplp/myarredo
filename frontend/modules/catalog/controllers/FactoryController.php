<?php

namespace frontend\modules\catalog\controllers;

use Yii;
use yii\web\Response;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;
use frontend\components\BaseController;
use frontend\modules\user\models\User;
use frontend\modules\catalog\models\{
    FactoryCatalogsFiles,
    Product,
    Factory,
    Sale,
    FactoryFileClickStats,
    CountriesFurniture
};

/**
 * Class FactoryController
 *
 * @package frontend\modules\catalog\controllers
 */
class FactoryController extends BaseController
{
    public $label = "Factory";

    public $title = "Factory";

    public $defaultAction = 'list';

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
                    'view' => ['get'],
                    'click-on-file' => ['post'],
                    'pdf-viewer' => ['get'],
                ],
            ],
        ];

        if (Yii::$app->getUser()->isGuest) {
            $behaviors[] = [
                'class' => \yii\filters\HttpCache::class,
                'only' => ['index'],
                'cacheControlHeader' => 'must-revalidate, max-age=86400',
                'lastModified' => function ($action, $params) {
                    $model = Product::findLastUpdated();
                    return $model['updated_at'];
                },
                'etagSeed' => function ($action, $params) {
                    $model = Product::findLastUpdated();
                    return serialize([
                        $model['title'],
                        $model['lang']['content']
                    ]);
                },
            ];

            $behaviors[] = [
                'class' => \yii\filters\HttpCache::class,
                'only' => ['view'],
                'cacheControlHeader' => 'must-revalidate, max-age=86400',
                'lastModified' => function ($action, $params) {
                    $model = Factory::findByAlias(Yii::$app->request->get('alias'));
                    return $model['updated_at'];
                },
                'etagSeed' => function ($action, $params) {
                    $model = Factory::findByAlias(Yii::$app->request->get('alias'));
                    return serialize([
                        $model['title'],
                        $model['lang'] ? $model['lang']['content'] : ''
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
        $model = new Factory();

        $params['producing_country_id'] = 4;

        $pageTitle[] = Yii::t('app', 'Итальянские фабрики мебели - производители из Италии');
        $pageDescription[] = Yii::t('app', 'Каталог итальянских производителей мебели - продукция лучших фабрик из Италии: кухни, гостиные, мягкая мебель. Заказать мебель итальянских фабрик');

        $models = $model->search(ArrayHelper::merge($params, Yii::$app->request->queryParams));

        if (Yii::$app->request->get('letter')) {
            $pageTitle[] = Yii::t('app', 'на букву') . ' ' . strtoupper(Yii::$app->request->get('letter'));
            $pageDescription[] = Yii::t('app', 'название на букву') . ' ' . strtoupper(Yii::$app->request->get('letter'));
        }

        if (DOMAIN_TYPE !== 'com') {
            $pageTitle[] = Yii::t('app', 'в') . ' ' . Yii::$app->city->getCityTitleWhere();
            $pageDescription[] = Yii::t('app', 'в') . ' ' . Yii::$app->city->getCityTitleWhere();
        }

        $this->title = implode(' ', $pageTitle);

        Yii::$app->view->registerMetaTag([
            'name' => 'description',
            'content' => implode(' ', $pageDescription),
        ]);

        Yii::$app->metatag->render();

        $factory_ids = [];
        foreach ($models->getModels() as $obj) {
            $factory_ids[] = $obj['id'];
        }

        $categories = Factory::getFactoryCategory($factory_ids);
        $factory_categories = [];
        foreach ($categories as $item) {
            $factory_categories[$item['factory_id']][] = $item;
        }

        return $this->render('list', [
            'models' => $models->getModels(),
            'pages' => $models->getPagination(),
            'factory_categories' => $factory_categories
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
        $keys = Yii::$app->catalogFilter->keys;

        $model = Factory::findByAlias($alias);

        if ($model == null) {
            throw new NotFoundHttpException(Yii::t('yii', 'Page not found.'));
        }

        /** @var Catalog $module */
        $module = Yii::$app->getModule('catalog');
        $module->itemOnPage = 20;

        $modelProduct = new Product();
        $product = $modelProduct->search([
            'defaultPageSize' => 20,
            $keys['factory'] => [
                $model['alias']
            ],
            'sort' => 'novelty'
        ]);

        $modelSale = new Sale();
        $saleProduct = null;

        if ($saleProduct == null) {
            $saleProduct = $modelSale->search([
                'defaultPageSize' => 6,
                $keys['factory'] => [
                    $model['alias']
                ],
                'city' => Yii::$app->city->getCityId()
            ]);

            $hostInfoSale = Yii::$app->request->hostInfo;
        }

        if ($saleProduct == null && isset(Yii::$app->partner->profile) && Yii::$app->partner->profile->partner_in_city_paid) {
            $saleProduct = $modelSale->search([
                'defaultPageSize' => 6,
                $keys['factory'] => [
                    $model['alias']
                ],
                'user_id' => Yii::$app->partner->id,
                'city' => Yii::$app->partner->profile->city_id
            ]);

            $hostInfoSale = Yii::$app->request->hostInfo;
        }

        if ($saleProduct == null) {
            $partner = User::getPartner(4);

            $saleProduct = $modelSale->search([
                'defaultPageSize' => 6,
                $keys['factory'] => [
                    $model['alias']
                ],
                'user_id' => $partner->id,
                'city' => $partner->profile->city_id
            ]);

            $hostInfoSale = 'https://www.myarredo.ru';
        }

        /*$modelItalianProduct = new ItalianProduct();
        $italianProduct = $modelItalianProduct->search([
            'defaultPageSize' => 6,
            $keys['factory'] => [
                $model['alias']
            ]
        ]);*/

        $modelCountriesFurniture = new CountriesFurniture();
        $countriesFurnitureProduct = $modelCountriesFurniture->search([
            'defaultPageSize' => 6,
            $keys['factory'] => [
                $model['alias']
            ]
        ]);

        $this->breadcrumbs[] = [
            'label' => Yii::t('app', 'Итальянские фабрики мебели'),
            'url' => ['/catalog/factory/list']
        ];

        $this->breadcrumbs[] = [
            'label' => $model['title'] .
                (DOMAIN_TYPE == 'com' ? ' ' . Yii::t('app', 'в') . ' ' . Yii::$app->city->getCityTitleWhere() : ''),
            'url' => ['/catalog/factory/view', 'alias' => $model['alias']]
        ];

        Yii::$app->metatag->render();

        $this->title = Yii::$app->metatag->seo_title
            ? Yii::$app->metatag->seo_title
            : $model['title'] .
            (DOMAIN_TYPE == 'com' ? ' - ' . Yii::t('app', 'мебели из Италии в') . ' ' . Yii::$app->city->getCityTitleWhere() : '');

        if (!Yii::$app->metatag->seo_description) {
            Yii::$app->view->registerMetaTag([
                'name' => 'description',
                'content' => Yii::t('app', 'Каталог итальянской мебели от фабрики') . ' ' . $model['title'] .
                    (DOMAIN_TYPE == 'com' ? ' ' . Yii::t('app', 'в интернет-магазине Myarredo. Заказать мебель из Италии в') . ' ' . Yii::$app->city->getCityTitleWhere() : ''),
            ]);
        }

        return $this->render('view', [
            'model' => $model,
            'product' => $product->getModels(),
            'saleProduct' => $saleProduct->getModels(),
            'hostInfoSale' => $hostInfoSale,
            //'italianProduct' => $italianProduct->getModels(),
            'countriesFurnitureProduct' => $countriesFurnitureProduct->getModels(),
        ]);
    }

    /**
     * @param string $alias
     * @param string $tab
     * @return string
     * @throws NotFoundHttpException
     * @throws \Throwable
     * @throws \yii\base\InvalidConfigException
     */
    public function actionViewTab(string $alias, $tab = '')
    {
        $model = Factory::findByAlias($alias);

        if ($model == null) {
            throw new NotFoundHttpException(Yii::t('yii', 'Page not found.'));
        }

        $this->breadcrumbs[] = [
            'label' => Yii::t('app', 'Итальянские фабрики мебели'),
            'url' => ['/catalog/factory/list']
        ];

        $this->breadcrumbs[] = [
            'label' => $model['title'] .
                (DOMAIN_TYPE == 'com' ? ' ' . Yii::t('app', 'в') . ' ' . Yii::$app->city->getCityTitleWhere() : ''),
            'url' => ['/catalog/factory/view', 'alias' => $model['alias']]
        ];

        Yii::$app->metatag->render();

        $this->title = Yii::$app->metatag->seo_title
            ? Yii::$app->metatag->seo_title
            : $model['title'] .
            (DOMAIN_TYPE == 'com' ? ' - ' . Yii::t('app', 'мебели из Италии в') . ' ' . Yii::$app->city->getCityTitleWhere() : '');

        if ($tab == 'collections') {
            $this->title = Yii::t('app', 'Все коллекции') . ': ' . $this->title;
        } elseif ($tab == 'articles') {
            $this->title = Yii::t('app', 'Все артикулы') . ': ' . $this->title;
        } elseif ($tab == 'catalogs') {
            $this->title = Yii::t('app', 'Каталоги') . ': ' . $this->title;
        } elseif ($tab == 'samples') {
            $this->title = Yii::t('app', 'Варианты отделки') . ': ' . $this->title;
        } elseif ($tab == 'pricelists') {
            $this->title = Yii::t('app', 'Прайс листы') . ': ' . $this->title;
        } elseif ($tab == 'grezzo') {
            $this->title = Yii::t('app', 'Мебель со сроком производства от ... до ...') . ': ' . $this->title;
        } elseif ($tab == 'orders') {
            $this->title = Yii::t('app', 'Orders') . ': ' . $this->title;
        } elseif ($tab == 'working-conditions') {
            $this->title = Yii::t('app', 'Условия работы') . ': ' . $this->title;
        }

        if (!Yii::$app->metatag->seo_description) {
            Yii::$app->view->registerMetaTag([
                'name' => 'description',
                'content' => Yii::t('app', 'Каталог итальянской мебели от фабрики') . ' ' . $model['title'] .
                    (DOMAIN_TYPE == 'com' ? ' ' . Yii::t('app', 'в интернет-магазине Myarredo. Заказать мебель из Италии в') . ' ' . Yii::$app->city->getCityTitleWhere() : ''),
            ]);
        }

        return $this->render('view_tab', [
            'model' => $model,
            'tab' => $tab,
        ]);
    }

    /**
     * @return array
     */
    public function actionClickOnFile()
    {
        $response = ['success' => 0];
        Yii::$app->getResponse()->format = Response::FORMAT_JSON;

        if (Yii::$app->request->isAjax && Yii::$app->getRequest()->post('id') && !Yii::$app->getUser()->isGuest && Yii::$app->user->identity->group->role == 'partner') {
            FactoryFileClickStats::create(Yii::$app->getRequest()->post('id'));
            $response['success'] = 1;
        }

        return $response;
    }

    /**
     * @return string
     */
    public function actionPdfViewer()
    {
        $this->layout = 'pdfjs';

        return $this->render('pdfjs', []);
    }
}
