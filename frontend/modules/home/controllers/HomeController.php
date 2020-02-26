<?php

namespace frontend\modules\home\controllers;

use frontend\modules\articles\models\Article;
use Yii;
use yii\web\ErrorAction;
//
use frontend\components\BaseController;
use frontend\themes\myarredo\assets\AppAsset;
use frontend\modules\catalog\models\{
    Product, ItalianProduct
};

/**
 * Class HomeController
 *
 * @package frontend\modules\home\controllers
 */
class HomeController extends BaseController
{
    public $layout = "@app/layouts/start";

    /**
     * @return array
     */
    public function behaviors()
    {
        $behaviors = [];

        if (Yii::$app->getUser()->isGuest) {
            $behaviors[] = [
                'class' => \yii\filters\HttpCache::class,
                'only' => ['index'],
                'cacheControlHeader' => 'must-revalidate, max-age=86400',
                'lastModified' => function ($action, $params) {
                    // ProductsNoveltiesOnMain widget
                    $timeLastUpdate[] = Product::findBaseArray()
                        ->andWhere([Product::tableName() . '.onmain' => '1'])
                        ->max(Product::tableName() . '.updated_at');

                    // SaleItalyOnMainPage widget
                    $timeLastUpdate[] = ItalianProduct::findBase()
                        ->max(ItalianProduct::tableName() . '.updated_at');

                    // ArticlesList widget
                    $timeLastUpdate[] = Article::findBase()
                        ->limit(3)
                        ->max(Article::tableName() . '.updated_at');

                    return max($timeLastUpdate);
                },
            ];
        }

        return $behaviors;
    }

    /**
     * @return array
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => ErrorAction::class,
                'view' => 'error',
            ],
        ];
    }

    /**
     * @return string
     */
    public function actionIndex()
    {
        Yii::$app->metatag
            ->render()
            ->setImageUrl(Yii::$app->request->hostInfo . AppAsset::register(Yii::$app->view)->baseUrl . 'img/logo.svg')
            ->renderGraph();

        return $this->render('index');
    }

    /**
     * @param $action
     * @return bool
     */
    public function beforeAction($action)
    {
        if ($action->id == 'error') {
            $this->layout = '/error';
        }

        return parent::beforeAction($action);
    }
}
