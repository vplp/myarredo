<?php

namespace frontend\modules\news\controllers;

use yii\filters\VerbFilter;
//
use thread\actions\RecordView;
//
use frontend\components\BaseController;
use frontend\modules\news\models\Article;

/**
 * Class ArticleController
 *
 * @package frontend\modules\news\controllers
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
                    'index' => ['get'],
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
            ],
        ];
    }
}
