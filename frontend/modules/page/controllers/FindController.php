<?php

namespace frontend\modules\page\controllers;

use frontend\components\BaseController;
use frontend\modules\news\models\Article;
use frontend\modules\page\models\Page;

/**
 * Class PageController
 *
 * @package frontend\modules\page\controllers
 */
class FindController extends BaseController
{
    public $title = "Page";
    public $layout = "/page";
    public $defaultAction = 'index';
    public $model;

    /**
     * @return array
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => \yii\filters\VerbFilter::class,
                'actions' => [
                    'index' => ['get'],
                    'contacts' => ['get'],
                    'view' => ['get'],
                ],
            ]
        ];
    }

    /**
     * @param $condition - строка поиска
     * @return mixed
     */
    public function actionIndex($condition)
    {
        $pagesModels = Page::findBase()->innerJoinWith('lang')
            ->orWhere(['LIKE', 'title', $condition])
            ->orWhere(['LIKE', 'content', $condition])
            ->all();

        $articleModels = Article::findBase()->innerJoinWith('lang')
            ->orWhere(['LIKE', 'title', $condition])
            ->orWhere(['LIKE', 'description', $condition])
            ->all();

        $posts = array_merge($pagesModels, $articleModels);

        return $this->render('index', ['condition' => $condition, 'posts' => $posts]);
    }
}
