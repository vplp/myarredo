<?php

namespace frontend\modules\articles\controllers;

use Yii;
use yii\helpers\Url;
use yii\filters\VerbFilter;
//
use frontend\components\BaseController;
use frontend\modules\articles\models\Article;
//
use thread\actions\RecordView;

/**
 * Class ArticleController
 *
 * @package frontend\modules\articles\controllers
 */
class ArticleController extends BaseController
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
                'class' => VerbFilter::class,
                'actions' => [
                    'index' => ['get', 'post'],
                ],
            ],
        ];
    }

    /**
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
            ],
        ];
    }

    /**
     * @param $action
     * @return bool
     */
    public function beforeAction($action)
    {
        if (Yii::$app->city->getCityId() != 4) {
            return $this->redirect('https://' . 'www.myarredo.ru' . Url::current(), 301);
        }

        return parent::beforeAction($action);
    }
}
