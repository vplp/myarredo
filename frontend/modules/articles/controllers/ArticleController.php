<?php

namespace frontend\modules\articles\controllers;

use Yii;
use yii\helpers\Url;
use thread\actions\RecordView;
use frontend\modules\articles\models\Article;

/**
 * Class ArticleController
 *
 * @package frontend\modules\articles\controllers
 */
class ArticleController extends \frontend\components\BaseController
{
    public $title = "Article";
    public $defaultAction = 'index';

    /**
     * @return array
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => \yii\filters\VerbFilter::class,
                'actions' => [
                    'index' => ['get', 'post'],
                ],
            ],
        ];
    }

    /**
     *
     * @return array
     */
    public function actions()
    {
        return [
            'index' => [
                'class' => RecordView::class,
                'modelClass' => Article::class,
                'methodName' => 'findByAlias',
                'view' => 'article',
                'layout' => "/column2"
            ],
        ];
    }

    /**
     * @param $action
     * @return bool|\yii\web\Response
     * @throws \yii\base\ExitException
     * @throws \yii\web\BadRequestHttpException
     */
    public function beforeAction($action)
    {
        /**
         * breadcrumbs
         */
        $this->breadcrumbs[] = [
            'label' => Yii::t('app', 'Articles'),
            'url' => Url::toRoute(['/articles/list/index'])
        ];

        return parent::beforeAction($action);
    }
}
