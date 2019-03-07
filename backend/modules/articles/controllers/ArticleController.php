<?php

namespace backend\modules\articles\controllers;

use yii\helpers\ArrayHelper;
//
use backend\modules\articles\models\{
    Article, ArticleLang, search\Article as filterArticleModel
};
//
use thread\actions\fileapi\{
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
