<?php

namespace frontend\modules\catalog\controllers;

use Yii;
use yii\web\Response;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;
use frontend\components\BaseController;
use frontend\modules\user\models\User;
use frontend\modules\catalog\widgets\filter\ProductFilter;
use frontend\modules\catalog\widgets\filter\ProductFilterSizes;
use frontend\modules\catalog\models\{
    Collection,
    Colors,
    Product,
    Category,
    Factory,
    ProductRelSpecification,
    ProductStats,
    Sale,
    SaleStats,
    SubTypes,
    Types,
    Specification
};

/**
 * Class TemplateFactoryController
 *
 * @package frontend\modules\catalog\controllers
 */
class TemplateFactoryController extends BaseController
{
    public $label = "TemplateFactory";
    public $title = "TemplateFactory";
    public $layout = '@app/layouts/template-factory';

    public $factory = [];

    /**
     * @param string $alias
     * @return string
     * @throws NotFoundHttpException
     * @throws \Throwable
     * @throws \yii\base\InvalidConfigException
     */
    public function actionFactory(string $alias)
    {
        $keys = Yii::$app->catalogFilter->keys;

        $model = Factory::findByAlias($alias);

        if ($model == null) {
            throw new NotFoundHttpException(Yii::t('yii', 'Page not found.'));
        }

        /** @var Catalog $module */
        $module = Yii::$app->getModule('catalog');
        $module->itemOnPage = 19;

        $modelProduct = new Product();
        $product = $modelProduct->search([
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
                (DOMAIN_TYPE != 'com' ? ' ' . Yii::t('app', 'в') . ' ' . Yii::$app->city->getCityTitleWhere() : ''),
            'url' => ['/catalog/factory/view', 'alias' => $model['alias']]
        ];

        $this->title = Yii::t('app', 'Итальянская мебель') . ' ' .
            $model['title'] . '. ' .
            (DOMAIN_TYPE != 'com' ? Yii::t('app', 'Купить в') . ' ' . Yii::$app->city->getCityTitleWhere() . ' ' . Yii::t('app', 'по лучшей цене') : '');

        $this->factory = $model;

        return $this->render('factory', [
            'model' => $model,
            'product' => $product->getModels(),
        ]);
    }

    /**
     * @param string $alias
     * @return string
     * @throws NotFoundHttpException
     * @throws \Throwable
     * @throws \yii\base\InvalidConfigException
     */
    public function actionContacts(string $alias)
    {
        $model = Factory::findByAlias($alias);

        if ($model == null) {
            throw new NotFoundHttpException(Yii::t('yii', 'Page not found.'));
        }

        $partners = User::getPartners(Yii::$app->city->getCityId());

        $this->factory = $model;

        $this->title = Yii::t('app', 'Партнеры сети MYARREDO в') . ' ' .
            Yii::$app->city->getCityTitleWhere();

        return $this->render('contacts', [
            'model' => $model,
            'partners' => $partners,
        ]);
    }

    /**
     * @param string $alias
     * @return string
     * @throws NotFoundHttpException
     * @throws \Throwable
     * @throws \yii\base\InvalidConfigException
     */
    public function actionCatalog(string $alias)
    {
        $factory = Factory::findByAlias($alias);

        if ($factory == null) {
            throw new NotFoundHttpException(Yii::t('yii', 'Page not found.'));
        }

        $this->factory = $factory;

        $model = new Product();

        Yii::$app->catalogFilter->parserUrl();

        $keys = Yii::$app->catalogFilter->keys;

        if (!isset(Yii::$app->catalogFilter->params[$keys['factory']])) {
            Yii::$app->catalogFilter->setParam($keys['factory'], $factory['alias']);
        } else if (count(Yii::$app->catalogFilter->params[$keys['factory']]) > 1) {
            throw new NotFoundHttpException(Yii::t('yii', 'Page not found.'));
        }

        $queryParams = Yii::$app->catalogFilter->params;

        $models = $model->search(ArrayHelper::merge(Yii::$app->request->queryParams, $queryParams));

        $this->title = Yii::t('app', 'Каталог итальянской мебели') . ' ' .
            $factory['title'] . '. ' .
            (DOMAIN_TYPE != 'com' ? Yii::t('app', 'Купить в') . ' ' . Yii::$app->city->getCityTitleWhere() . ' ' . Yii::t('app', 'по лучшей цене') : '');

        return $this->render('catalog', [
            'factory' => $factory,
            'models' => $models->getModels(),
            'pages' => $models->getPagination(),
        ]);
    }

    /**
     * @param string $alias
     * @param string $product
     * @return string
     * @throws NotFoundHttpException
     * @throws \Exception
     * @throws \Throwable
     */
    public function actionProduct(string $alias, string $product)
    {
        $factory = Factory::findByAlias($alias);

        if ($factory == null) {
            throw new NotFoundHttpException(Yii::t('yii', 'Page not found.'));
        }

        $this->factory = $factory;

        $model = Product::findByAlias($product);

        if ($model == null || $model['factory_id'] != $factory->id) {
            throw new NotFoundHttpException(Yii::t('yii', 'Page not found.'));
        }

        // ProductStats
        ProductStats::create($model->id);

        $this->breadcrumbs[] = [
            'label' => Yii::t('app', 'Каталог итальянской мебели'),
            'url' => ['/catalog/category/list']
        ];

        $keys = Yii::$app->catalogFilter->keys;


        if (isset($model['category'][0])) {
            $params = Yii::$app->catalogFilter->params;
            $params[$keys['category']] = $model['category'][0][Yii::$app->languages->getDomainAlias()];

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

        $this->title = $model['lang']['title'] . '. ' .
            (DOMAIN_TYPE != 'com' ? Yii::t('app', 'Купить в') . ' ' . Yii::$app->city->getCityTitleWhere() : '');

        return $this->render('/product/view', [
            'model' => $model,
        ]);
    }

    /**
     * @param string $alias
     * @return string
     * @throws NotFoundHttpException
     * @throws \Throwable
     * @throws \yii\base\InvalidConfigException
     */
    public function actionSale(string $alias)
    {
        $factory = Factory::findByAlias($alias);

        if ($factory == null) {
            throw new NotFoundHttpException(Yii::t('yii', 'Page not found.'));
        }

        $this->factory = $factory;

        $model = new Sale();

        $keys = Yii::$app->catalogFilter->keys;
        $params = Yii::$app->catalogFilter->params;

        $params[$keys['factory']] = [$factory['alias']];

        $models = $model->search(ArrayHelper::merge(Yii::$app->request->queryParams, $params));

        $this->title = Yii::t('app', 'Распродажа итальянской мебели') . ' ' . $factory['title'];

        return $this->render('sale', [
            'factory' => $factory,
            'models' => $models->getModels(),
            'pages' => $models->getPagination(),
        ]);
    }

    /**
     * @param string $alias
     * @param string $product
     * @return string
     * @throws NotFoundHttpException
     * @throws \Throwable
     * @throws \yii\base\InvalidConfigException
     */
    public function actionSaleProduct(string $alias, string $product)
    {
        $factory = Factory::findByAlias($alias);

        if ($factory == null) {
            throw new NotFoundHttpException(Yii::t('yii', 'Page not found.'));
        }

        $this->factory = $factory;

        $model = Sale::findByAlias($product);

        if ($model == null) {
            throw new NotFoundHttpException(Yii::t('yii', 'Page not found.'));
        }

        // SaleStats
        SaleStats::create($model->id);

        $this->breadcrumbs[] = [
            'label' => Yii::t('app', 'Каталог итальянской мебели'),
            'url' => ['/catalog/category/list']
        ];

        $this->title = Yii::t('app', 'Sale') . ': ' .
            $model['lang']['title'] .
            ' - ' . $model['price_new'] . ' ' . $model['currency'] . ' - ' .
            Yii::t('app', 'интернет-магазин Myarredo в') . ' ' .
            Yii::$app->city->getCityTitleWhere();

        Yii::$app->view->registerMetaTag([
            'name' => 'description',
            'content' => strip_tags($model['lang']['description']) . ' ' .
                Yii::t('app', 'Купить в интернет-магазине Myarredo в') . ' ' .
                Yii::$app->city->getCityTitleWhere()
        ]);

        return $this->render('/sale/view', [
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
                'html' => ProductFilter::widget([
                    'route' => Yii::$app->getRequest()->post('link'),
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
                    'modelProductRelSpecificationClass' => ProductRelSpecification::class,
                    'route' => Yii::$app->getRequest()->post('link'),
                    'catalogFilterParams' => Yii::$app->getRequest()->post('catalogFilterParams')
                ])
            ];
        }
    }

    /**
     * @param string $alias
     * @return string
     * @throws NotFoundHttpException
     * @throws \Throwable
     * @throws \yii\base\InvalidConfigException
     */
    public function actionCatalogsFiles(string $alias)
    {
        $factory = Factory::findByAlias($alias);

        if ($factory == null) {
            throw new NotFoundHttpException(Yii::t('yii', 'Page not found.'));
        }

        $this->factory = $factory;

        $this->title = Yii::t('app', 'Каталоги') . ' ' . $factory['title'];

        return $this->render('catalogs_files', [
            'factory' => $factory,
        ]);
    }
    /**
     * @param string $alias
     * @return string
     * @throws NotFoundHttpException
     * @throws \Throwable
     * @throws \yii\base\InvalidConfigException
     */
    public function actionWorkingConditions(string $alias)
    {
        $factory = Factory::findByAlias($alias);

        if ($factory == null) {
            throw new NotFoundHttpException(Yii::t('yii', 'Page not found.'));
        }

        $this->factory = $factory;

        $this->title = Yii::t('app', 'Условия работы') . ' ' . $factory['title'];

        return $this->render('working_conditions', [
            'factory' => $factory,
        ]);
    }

    /**
     * @param string $alias
     * @return string
     * @throws NotFoundHttpException
     * @throws \Throwable
     * @throws \yii\base\InvalidConfigException
     */
    public function actionPricesFiles(string $alias)
    {
        $factory = Factory::findByAlias($alias);

        if ($factory == null) {
            throw new NotFoundHttpException(Yii::t('yii', 'Page not found.'));
        }

        $this->factory = $factory;

        $this->title = Yii::t('app', 'Прайс листы') . ' ' . $factory['title'];

        return $this->render('prices_files', [
            'model' => $factory,
        ]);
    }
}
