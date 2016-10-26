<?php

namespace frontend\modules\news\controllers;

use yii\filters\VerbFilter;
//
use thread\actions\RecordView;
//
use frontend\modules\news\models\Article;

/**
 * Class ArticleController
 *
 * @package frontend\modules\news\controllers
 * @author Andrii Bondarchuk
 * @copyright (c) 2016
 */
class ArticleController extends \frontend\components\BaseController
{

    public $title = "Article";
    public $layout = "@app/layouts/column1";
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
