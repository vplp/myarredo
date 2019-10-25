<?php

namespace frontend\modules\catalog\controllers;

use Yii;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
//
use frontend\components\BaseController;
use frontend\modules\catalog\models\{
    Product, Factory, ItalianProduct
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
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'list' => ['get'],
                    'view' => ['get'],
                ],
            ],
        ];
    }

    /**
     * @return string
     * @throws NotFoundHttpException
     * @throws \Throwable
     * @throws \yii\base\InvalidConfigException
     */
    public function actionList()
    {
        $model = new Factory();

        $params = [];

        $pageTitle[] = Yii::t('app', 'Итальянские фабрики мебели - производители из Италии');
        $pageDescription[] = Yii::t('app', 'Каталог итальянских производителей мебели - продукция лучших фабрик из Италии: кухни, гостиные, мягкая мебель. Заказать мебель итальянских фабрик');

        $models = $model->search(ArrayHelper::merge($params, Yii::$app->request->queryParams));

        $view = Yii::$app->request->get('view');

        if (Yii::$app->request->get('letter')) {
            $pageTitle[] = Yii::t('app', 'на букву') . ' ' . strtoupper(Yii::$app->request->get('letter'));
            $pageDescription[] = Yii::t('app', 'название на букву') . ' ' . strtoupper(Yii::$app->request->get('letter'));
        }

        if (Yii::$app->city->domain !== 'com') {
            $pageTitle[] = Yii::t('app', 'в') . ' ' . Yii::$app->city->getCityTitleWhere();
            $pageDescription[] = Yii::t('app', 'в') . ' ' . Yii::$app->city->getCityTitleWhere();
        }

        if ($view && $view !== 'three') {
            throw new NotFoundHttpException(Yii::t('yii', 'Page not found.'));
        }

        $this->title = implode(' ', $pageTitle);

        Yii::$app->view->registerMetaTag([
            'name' => 'description',
            'content' => implode(' ', $pageDescription),
        ]);

        Yii::$app->metatag->render();

        if ($view == 'three') {
            foreach ($models->getModels() as $obj) {
                $_models[$obj['first_letter']][] = $obj;
            }

            return $this->render('list_three', [
                'models' => $_models,
                'pages' => $models->getPagination(),
            ]);
        } else {
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
            $keys['factory'] => [
                $model['alias']
            ]
        ]);

        $modelItalianProduct = new ItalianProduct();
        $italianProduct = $modelItalianProduct->search([
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
                (Yii::$app->city->domain == 'com' ? ' ' . Yii::t('app', 'в') . ' ' . Yii::$app->city->getCityTitleWhere() : ''),
            'url' => ['/catalog/factory/view', 'alias' => $model['alias']]
        ];

        Yii::$app->metatag->render();

        $this->title = Yii::$app->metatag->seo_title
            ? Yii::$app->metatag->seo_title
            : $model['title'] .
            (Yii::$app->city->domain == 'com' ? ' - ' . Yii::t('app', 'мебели из Италии в') . ' ' . Yii::$app->city->getCityTitleWhere() : '');

        if (!Yii::$app->metatag->seo_description) {
            Yii::$app->view->registerMetaTag([
                'name' => 'description',
                'content' => Yii::t('app', 'Каталог итальянской мебели от фабрики') . ' ' . $model['title'] .
                    (Yii::$app->city->domain == 'com' ? ' ' . Yii::t('app', 'в интернет-магазине Myarredo. Заказать мебель из Италии в') . ' ' . Yii::$app->city->getCityTitleWhere() : ''),
            ]);
        }

        return $this->render('view', [
            'model' => $model,
            'product' => $product->getModels(),
            'italianProduct' => $italianProduct->getModels(),
        ]);
    }
}
