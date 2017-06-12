<?php

namespace frontend\modules\catalog\controllers;

use Yii;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;
//
use frontend\components\BaseController;
use frontend\modules\catalog\models\{
    Product, Group
};

/**
 * Class GroupController
 *
 * @package frontend\modules\catalog\controllers
 * @author Andrii Bondarchuk
 * @copyright (c) 2016
 */
class GroupController extends BaseController
{
    public $title = "Group";
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
                    'index' => ['get'],
                ],
            ],
        ];
    }

    /**
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionIndex()
    {
        $m = new Product();

        if (Yii::$app->request->get('alias')) {
            $item = Group::findByAlias(Yii::$app->request->get('alias'));

            if ($item === null)
                throw new NotFoundHttpException;
        }

        $model = $m->search(ArrayHelper::merge(['group_id' => $item['id']], Yii::$app->request->queryParams));

        return $this->render('group', [
            'models' => $model->getModels(),
            'pages' => $model->getPagination(),
        ]);

    }

    /**
     *
     * @param string $action
     * @return boollean
     */
    public function beforeAction($action)
    {
        $item = (isset($_GET['alias']))
            ? Group::findByAlias($_GET['alias'])
            : null;

        if ($item !== null) {
            $this->title = $item['lang']['title'];
        }

        // breadcrumbs
        if ($item->parent) {
            $parent = $item->parent;
            $this->breadcrumbs[] = [
                'label' => $parent['lang']['title'],
                'url' => $parent->getUrl()
            ];
        }

        $this->breadcrumbs[] = $item['lang']['title'];

        return parent::beforeAction($action);
    }
}