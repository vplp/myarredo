<?php

namespace frontend\modules\home\controllers;

use frontend\modules\articles\models\Article;
use Yii;
use yii\web\ErrorAction;
use frontend\components\BaseController;
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
                    $model = Product::findLastUpdated();
                    $timeLastUpdate[] = $model['updated_at'];

                    // SaleItalyOnMainPage widget
//                    $model = ItalianProduct::findLastUpdated();
//                    $timeLastUpdate[] = $model['updated_at'];

                    // ArticlesList widget
                    $model = Article::findLastUpdated();
                    $timeLastUpdate[] = $model['updated_at'];

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
            ->setImageUrl('https://img.' . DOMAIN_NAME . '.' . DOMAIN_TYPE . '/uploads/myarredo-ico.jpg')
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

            Yii::$app->view->registerMetaTag([
                'name' => 'robots',
                'content' => 'noindex, nofollow',
            ]);
        }

        return parent::beforeAction($action);
    }
}
