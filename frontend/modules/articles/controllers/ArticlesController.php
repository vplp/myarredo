<?php

namespace frontend\modules\articles\controllers;

use Yii;
use yii\helpers\Url;
use yii\filters\VerbFilter;
//
use frontend\components\BaseController;
use frontend\modules\articles\models\Article;
//
use thread\actions\{
    ListQuery, RecordView
};

/**
 * Class ArticlesController
 *
 * @package frontend\modules\articles\controllers
 */
class ArticlesController extends BaseController
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
            'list' => [
                'class' => ListQuery::class,
                'query' => Article::findBase(),
                'recordOnPage' => $this->module->itemOnPage,
            ],
            'view' => [
                'class' => RecordView::class,
                'modelClass' => Article::class,
                'methodName' => 'findByAlias',
                //'view' => 'article',
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
            return $this->redirect('https://' . 'www.myarredo.ru' . Url::toRoute('/articles/articles/list'), 301);
        }

        $this->title = Yii::t('app', 'Articles');

        return parent::beforeAction($action);
    }
}
