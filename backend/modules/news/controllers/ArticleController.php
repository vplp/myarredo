<?php

namespace backend\modules\news\controllers;

use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use common\actions\upload\{
    DeleteAction, UploadAction
};
use thread\actions\EditableAttributeSave;
use thread\actions\EditableAttributeSaveLang;
use thread\app\base\controllers\BackendController;
use backend\modules\news\models\{
    Article, ArticleLang, search\Article as filterArticleModel
};

/**
 * Class ArticleController
 *
 * @package backend\modules\news\controllers
 */
class ArticleController extends BackendController
{
    public $model = Article::class;
    public $modelLang = ArticleLang::class;
    public $filterModel = filterArticleModel::class;
    public $title = 'Article';
    public $name = 'article';

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
                        'roles' => ['admin', 'seo'],
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
                'attribute-save' => [
                    'class' => EditableAttributeSaveLang::class,
                    'modelClass' => $this->modelLang,
                    'attribute' => 'title',
                ],
                'attribute-save-group' => [
                    'class' => EditableAttributeSave::class,
                    'modelClass' => $this->model,
                    'attribute' => 'group_id',
                    'returnValue' => function ($model) {
                        return $model['group']['lang']['title'] ?? '---';
                    }
                ]
            ]
        );
    }
}
