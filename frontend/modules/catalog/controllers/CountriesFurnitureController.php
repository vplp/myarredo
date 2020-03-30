<?php

namespace frontend\modules\catalog\controllers;

use frontend\modules\catalog\widgets\filter\ItalianProductFilter;
use Yii;
use yii\helpers\{
    ArrayHelper
};
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
//
use frontend\components\BaseController;
use frontend\modules\catalog\models\{
    Product,
    ItalianProduct,
    ItalianProductLang,
    search\ItalianProduct as filterItalianProductModel,
    ItalianProductStats,
    Category,
    Factory,
    Types,
    SubTypes,
    Specification,
    Colors,
    CountriesFurniture
};
use frontend\themes\myarredo\assets\AppAsset;
use yii\web\Response;

/**
 * Class CountriesFurnitureController
 *
 * @package frontend\modules\catalog\controllers
 */
class CountriesFurnitureController extends BaseController
{
    public $label = "Countries furniture";

    public $title = "Countries furniture";

    public $defaultAction = 'list';

    protected $model = CountriesFurniture::class;

    protected $filterModel = CountriesFurniture::class;

    /**
     * @return array
     */
    public function behaviors()
    {
        $behaviors = [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'list' => ['get'],
                    'view' => ['post', 'get'],
                    'ajax-get-filter' => ['post'],
                ],
            ],
        ];

        return $behaviors;
    }

    /**
     * @return string
     * @throws \Throwable
     * @throws \yii\base\InvalidConfigException
     */
    public function actionList()
    {
        $model = new CountriesFurniture();

        Yii::$app->catalogFilter->parserUrl();

        $queryParams = Yii::$app->catalogFilter->params;

        $queryParams['defaultPageSize'] = 24;
        $models = $model->search(ArrayHelper::merge(Yii::$app->request->queryParams, $queryParams));

        return $this->render('list', [
            'models' => $models->getModels(),
            'pages' => $models->getPagination()
        ]);
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
        $model = Product::findByAlias($alias);

        if ($model == null) {
            $model = ItalianProduct::findByAlias($alias);
        }

        if ($model == null) {
            throw new NotFoundHttpException(Yii::t('yii', 'Page not found.'));
        }

        return $this->render(
            isset($model['price_new'])
                ? '/sale-italy/view'
                : '/product/view',
            [
                'model' => $model,
            ]
        );
    }
}
