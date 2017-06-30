<?php

namespace backend\modules\news\controllers;

use Yii;
use yii\helpers\ArrayHelper;
//
use thread\actions\fileapi\{
    DeleteAction, UploadAction
};
use thread\actions\EditableAttributeSave;
use thread\app\base\controllers\BackendController;
//
use backend\modules\news\models\{
    Article, ArticleLang, search\Article as filterArticleModel
};

/**
 * Class ArticleController
 *
 * @package backend\modules\news\controllers
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
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
    public function actions()
    {
        return ArrayHelper::merge(
            parent::actions(),
            [
                'list' => [
                    'layout' => 'list-article',
                ],
                'fileupload' => [
                    'class' => UploadAction::class,
                    'path' => $this->module->getArticleUploadPath()
                ],
                'filedelete' => [
                    'class' => DeleteAction::class,
                    'path' => $this->module->getArticleUploadPath()
                ],
                'attribute-save' => [
                    'class' => EditableAttributeSave::class,
                    'modelClass' => $this->model,
                    'attribute' => 'group_id'
                ],
            ]
        );
    }
}
