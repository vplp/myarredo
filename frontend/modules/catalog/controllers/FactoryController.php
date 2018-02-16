<?php

namespace frontend\modules\catalog\controllers;

use Yii;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
//
use frontend\components\BaseController;
use frontend\modules\catalog\models\{
    Product, Factory
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
     */
    public function actionList()
    {
        $model = new Factory();

        $params = [];

        $pageTitle[] = 'Итальянские фабрики мебели - производители из Италии';
        $pageDescription[] = 'Каталог итальянских производителей мебели - ' .
            'продукция лучших фабрик из Италии: кухни, гостиные, мягкая мебель. Заказать мебель итальянских фабрик';

        $models = $model->search(ArrayHelper::merge($params, Yii::$app->request->queryParams));

        $view = Yii::$app->request->get('view');

        if (Yii::$app->request->get('letter')) {
            $pageTitle[] = 'на букву ' . strtoupper(Yii::$app->request->get('letter'));
            $pageDescription[] = 'название на букву ' . strtoupper(Yii::$app->request->get('letter'));
        }

        $pageTitle[] = 'в ' . Yii::$app->city->getCityTitleWhere();
        $pageDescription[] = 'в ' . Yii::$app->city->getCityTitleWhere();

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
     */
    public function actionView(string $alias)
    {
        $keys = Yii::$app->catalogFilter->keys;

        $model = Factory::findByAlias($alias);

        Yii::$app->metatag->render();

        if ($model === null) {
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
            'label' => 'Итальянские фабрики мебели',
            'url' => ['/catalog/factory/list']
        ];

        $this->breadcrumbs[] = [
            'label' => $model['title'] . ' в ' . Yii::$app->city->getCityTitleWhere(),
            'url' => ['/catalog/factory/view', 'alias' => $model['alias']]
        ];

        $this->title = $model['title'] .
            ' - мебели из Италии в ' .
            Yii::$app->city->getCityTitleWhere();

        if (!Yii::$app->metatag->seo_description) {
            Yii::$app->view->registerMetaTag([
                'name' => 'description',
                'content' => 'Каталог итальянской мебели от фабрики' . $model['title'] .
                    ' в интернет-магазине Myarredo. Заказать мебель из Италии в ' .
                    Yii::$app->city->getCityTitleWhere(),
            ]);
        }

        Yii::$app->metatag->render();

        return $this->render('view', [
            'model' => $model,
            'product' => $product->getModels(),
        ]);
    }
}
