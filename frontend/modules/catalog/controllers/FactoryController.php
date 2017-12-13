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

        $models = $model->search(ArrayHelper::merge($params, Yii::$app->request->queryParams));
        $view = Yii::$app->request->get('view');

        if ($view && $view !== 'three') {
            throw new NotFoundHttpException;
        }

        $this->title = 'Итальянские фабрики мебели';

        if ($view == 'three') {
            /**
             * view three
             */
            foreach ($models->getModels() as $obj) {
                $_models[$obj['first_letter']][] = $obj;
            }
            return $this->render('list_three', [
                'models' => $_models,
                'pages' => $models->getPagination(),
            ]);
        } else {
            /**
             * view list
             */
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

        return $this->render('view', [
            'model' => $model,
            'product' => $product->getModels(),
        ]);
    }
}
