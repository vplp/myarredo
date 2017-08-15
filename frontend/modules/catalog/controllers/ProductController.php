<?php

namespace frontend\modules\catalog\controllers;

use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;
//
use frontend\modules\catalog\models\Product;
use frontend\components\BaseController;

/**
 * Class ProductController
 *
 * @package frontend\modules\news\controllers
 */
class ProductController extends BaseController
{
    public $title = "Product";
    public $defaultAction = 'view';

    /**
     * @return array
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'view' => ['get'],
                ],
            ],
        ];
    }

    /**
     * @param string $alias
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionView(string $alias)
    {
        $model = Product::findByAlias($alias);

        if ($model === null) {
            throw new NotFoundHttpException;
        }

        $this->breadcrumbs[] = [
            'label' => 'Каталог итальянской мебели',
            'url' => ['/catalog/category/list']
        ];
        $this->breadcrumbs[] = [
            'label' => $model['category'][0]['lang']['title'],
            'url' => ['/catalog/category/list']
        ];

        return $this->render('view', [
            'model' => $model,
        ]);
    }
}