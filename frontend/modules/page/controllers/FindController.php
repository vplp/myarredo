<?php

namespace frontend\modules\page\controllers;

use frontend\components\BaseController;
use frontend\modules\news\models\Article;
use frontend\modules\page\models\Page;

/**
 * Class PageController
 *
 * @package frontend\modules\page\controllers
 * @author Andrii Bondarchuk
 * @copyright (c) 2016
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

//        echo '<pre style="color:red">'; print_r($posts); echo '<pre>'; die();

        return $this->render('index', ['condition' => $condition, 'posts' => $posts]);
    }

//    /**
//     *
//     * @param string $alias
//     * @return string
//     * @throws NotFoundHttpException
//     */
//    public function actionView($alias)
//    {
//        $model = Page::findByAlias($alias);
//
//        if ($model === null) {
//            throw new NotFoundHttpException;
//        }
//
//        //layouts
//        if ($model->alias == 'contacts') {
//            $this->layout = 'contacts';
//            $view = 'index';
//        } else if ($model->alias == 'about') {
//            $this->layout = 'about';
//            $view = 'index';
//        } else {
//            $this->layout = 'privacy-policy';
//            $view = 'default';
//        }
//
//        $this->model = $model;
//
//        return $this->render($view, [
//            'model' => $model,
//        ]);
//    }

}
