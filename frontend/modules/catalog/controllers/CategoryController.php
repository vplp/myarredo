<?php

namespace frontend\modules\catalog\controllers;

use Yii;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
//
use thread\actions\ListQuery;
//
use frontend\components\BaseController;
use frontend\modules\catalog\models\{
    Product, Category
};

/**
 * Class CategoryController
 *
 * @package frontend\modules\catalog\controllers
 */
class CategoryController extends BaseController
{
    public $label = "Category";
    public $title = "Category";
    public $defaultAction = 'index';

    /**
     * @return array
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'index' => ['get'],
                ],
            ],
        ];
    }

    /**
     * @return array
     * @throws NotFoundHttpException
     */
    public function actions()
    {
        $g = function () {
            $r = 0;
            if (Yii::$app->request->get('alias')) {
                $item = Category::findByAlias(Yii::$app->request->get('alias'));

                if ($item === null)
                    throw new NotFoundHttpException;

                $r = $item['id'];

            }
            return $r;
        };

        $group = $g();

        return [
            'index' => [
                'class' => ListQuery::class,
                'query' => ($group) ? Product::findBase()->group_id($group) : Product::findBase(),
                'recordOnPage' => $this->module->itemOnPage,
            ],
        ];
    }
}
