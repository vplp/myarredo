<?php

namespace frontend\modules\catalog\controllers;

use Yii;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
//
use frontend\components\BaseController;
use frontend\modules\catalog\models\{
    Product, Factory, ProductStats, Sale
};
use frontend\modules\user\models\User;

/**
 * Class TemplateFactoryController
 *
 * @package frontend\modules\catalog\controllers
 */
class TemplateFactoryController extends BaseController
{
    public $label = "TemplateFactory";
    public $title = "TemplateFactory";
    public $layout = 'template-factory';

    public $factory = [];

    /**
     * @param string $alias
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionFactory(string $alias)
    {
        $keys = Yii::$app->catalogFilter->keys;

        $model = Factory::findByAlias($alias);

        if ($model === null) {
            throw new NotFoundHttpException;
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
            'label' => 'Итальянские фабрики мебели',
            'url' => ['/catalog/factory/list']
        ];

        $this->breadcrumbs[] = [
            'label' => $model['lang']['title'] . ' в ' . Yii::$app->city->getCityTitleWhere(),
            'url' => ['/catalog/factory/view', 'alias' => $model['alias']]
        ];

        $this->title = 'Итальянская мебель ' .
            $model['lang']['title'] .
            ' купить в ' .
            Yii::$app->city->getCityTitleWhere() .
            ' по лучшей цене';

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
     */
    public function actionContacts(string $alias)
    {
        $model = Factory::findByAlias($alias);

        if ($model === null) {
            throw new NotFoundHttpException;
        }

        $partners = User::getPartners(Yii::$app->city->getCityId());

        $this->factory = $model;

        $this->title = 'Партнеры сети MYARREDO в ' .
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
     */
    public function actionCatalog(string $alias)
    {
        $factory = Factory::findByAlias($alias);

        if ($factory === null) {
            throw new NotFoundHttpException;
        }

        $this->factory = $factory;

        $model = new Product();

        $keys = Yii::$app->catalogFilter->keys;
        $params = Yii::$app->catalogFilter->params;

        $params[$keys['factory']] = [$factory['alias']];

        $models = $model->search(ArrayHelper::merge(Yii::$app->request->queryParams, $params));

        $this->title = 'Каталог итальянской мебели ' .
            $factory['lang']['title'] .
            ' купить в ' .
            Yii::$app->city->getCityTitleWhere() .
            ' по лучшей цене';

        return $this->render('catalog', [
            'factory' => $factory,
            'models' => $models->getModels(),
            'pages' => $models->getPagination(),
        ]);
    }

    public function actionProduct(string $alias, string $product)
    {
        $factory = Factory::findByAlias($alias);

        if ($factory === null) {
            throw new NotFoundHttpException;
        }

        $this->factory = $factory;

        $model = Product::findByAlias($product);

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

        return $this->render('/product/view', [
            'model' => $model,
        ]);
    }

    /**
     * @param string $alias
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionSale(string $alias)
    {
        $factory = Factory::findByAlias($alias);

        if ($factory === null) {
            throw new NotFoundHttpException;
        }

        $this->factory = $factory;

        $model = new Sale();

        $keys = Yii::$app->catalogFilter->keys;
        $params = Yii::$app->catalogFilter->params;

        $params[$keys['factory']] = [$factory['alias']];

        $models = $model->search(ArrayHelper::merge(Yii::$app->request->queryParams, $params));

        $this->title = 'Распродажа итальянской мебели';

        return $this->render('sale', [
            'factory' => $factory,
            'models' => $models->getModels(),
            'pages' => $models->getPagination(),
        ]);
    }
}