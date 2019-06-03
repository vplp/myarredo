<?php

namespace frontend\modules\articles\controllers;

use Yii;
//
use frontend\components\BaseController;
use frontend\modules\articles\models\Article;
//
use thread\actions\ListQuery;

/**
 * Class ListController
 *
 * @package frontend\modules\articles\controllers
 */
class ListController extends BaseController
{
    public $label = "Articles";
    public $title = "Articles";
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
     * @return array
     */
    public function actions()
    {
        return [
            'index' => [
                'class' => ListQuery::class,
                'query' => Article::findBase(),
                'recordOnPage' => $this->module->itemOnPage,
            ],
        ];
    }

    /**
     * @param $action
     * @return bool
     */
    public function beforeAction($action)
    {
        $this->title = Yii::t('app', 'Articles');

        /**
         * breadcrumbs
         */
        $this->breadcrumbs[] = $this->title;

        return parent::beforeAction($action);
    }
}
