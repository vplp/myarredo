<?php

namespace frontend\modules\news\controllers;

use yii\filters\VerbFilter;
//
use thread\actions\RecordView;
//
use frontend\modules\news\models\ArticleForPartners;

/**
 * Class ArticleForPartnersController
 *
 * @package frontend\modules\news\controllers
 */
class ArticleForPartnersController extends \frontend\components\BaseController
{

    public $title = "ArticleForPartners";
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
     * @param $id
     * @return string
     * @throws ForbiddenHttpException
     */
    public function actionIndex($id)
    {
        $model = ArticleForPartners::findById($id);

        if (empty($model)) {
            throw new ForbiddenHttpException('Access denied');
        }

        return $this->render('article_for_partners', [
            'model' => $model,
        ]);
    }

    /**
     * @return array
     */
//    public function actions()
//    {
//        return [
//            'index' => [
//                'class' => RecordView::class,
//                'modelClass' => ArticleForPartners::class,
//                'methodName' => 'findById',
//                'view' => 'article_for_partners',
//            ],
//        ];
//    }
}
