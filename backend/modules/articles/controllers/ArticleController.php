<?php

namespace backend\modules\articles\controllers;

use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use backend\modules\articles\models\{
    Article, ArticleLang, search\Article as filterArticleModel
};
use common\actions\upload\{
    DeleteAction, UploadAction
};
use thread\app\base\controllers\BackendController;

/**
 * Class ArticleController
 *
 * @package backend\modules\Articles\controllers
 */
class ArticleController extends BackendController
{
    public $model = Article::class;
    public $modelLang = ArticleLang::class;
    public $filterModel = filterArticleModel::class;
    public $title = 'Article';
    public $name = 'articles';

    /**
     * @return array
     */
    public function behaviors()
    {
        return [
            'AccessControl' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['error'],
                        'roles' => ['?', '@'],
                    ],
                    [
                        'allow' => true,
                        'roles' => ['admin', 'catalogEditor', 'seo'],
                    ],
                    [
                        'allow' => false,
                    ],
                ],
            ],
        ];
    }

    /**
     * @return array
     */
    public function actions()
    {
        return ArrayHelper::merge(
            parent::actions(),
            [
                'fileupload' => [
                    'class' => UploadAction::class,
                    'path' => $this->module->getArticleUploadPath()
                ],
                'filedelete' => [
                    'class' => DeleteAction::class,
                    'path' => $this->module->getArticleUploadPath()
                ],
            ]
        );
    }
}
