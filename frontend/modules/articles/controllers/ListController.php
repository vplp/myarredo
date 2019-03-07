<?php

namespace frontend\modules\articles\controllers;

use Yii;
use frontend\components\BaseController;
use thread\actions\ListQuery;
use frontend\modules\articles\models\Article;
use frontend\modules\articles\models\Group;
use yii\web\NotFoundHttpException;

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
        $g = function () {
            $r = 0;
            if (Yii::$app->request->get('alias')) {
                $item = Group::findByAlias(Yii::$app->request->get('alias'));

                if ($item === null)
                    throw new NotFoundHttpException(Yii::t('app', 'Page not found.'));

                $r = $item['id'];

            }
            return $r;
        };

        $group = $g();

        return [
            'index' => [
                'class' => ListQuery::class,
                'query' => ($group) ? Article::findBase()->group_id($group) : Article::findBase(),
                'recordOnPage' => $this->module->itemOnPage,
                'layout' => "/column1"
            ],
        ];
    }

    /**
     * @param \yii\base\Action $action
     * @return bool
     */
    public function beforeAction($action)
    {
        $this->title = Yii::t('app', 'Articles');

        $item = (isset($_GET['alias']))
            ? Group::findByAlias($_GET['alias'])
            : null;

        if ($item !== null) {
            $this->title = $item['lang']['title'];
        }

        /**
         * breadcrumbs
         */
        $this->breadcrumbs[] = $this->title;

        return parent::beforeAction($action);
    }
}
