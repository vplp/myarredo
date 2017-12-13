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
}