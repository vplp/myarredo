<?php

namespace frontend\modules\news\controllers;

use Yii;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
//
use thread\actions\ListQuery;
//
use frontend\components\BaseController;
use frontend\modules\news\models\{
    Article, Group
};

/**
 * Class ListController
 *
 * @package frontend\modules\news\controllers
 */
class ListController extends BaseController
{
    public $label = "News";
    public $title = "News";
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
     * @return array
     */
    public function actions()
    {
        $g = function () {
            $r = 0;
            if (Yii::$app->request->get('alias')) {
                $item = Group::findByAlias(Yii::$app->request->get('alias'));

                if ($item == null) {
                    throw new NotFoundHttpException(Yii::t('yii', 'Page not found.'));
                }

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
            ],
        ];
    }

    /**
     * @param $action
     * @return bool
     * @throws \yii\web\BadRequestHttpException
     */
    public function beforeAction($action)
    {
        $item = (isset($_GET['alias']))
            ? Group::findByAlias($_GET['alias'])
            : null;

        if ($item != null) {
            $this->label = $item['lang']['title'];
        }

        return parent::beforeAction($action);
    }
}
