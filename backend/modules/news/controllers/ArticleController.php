<?php
namespace backend\modules\news\controllers;

use Yii;
use yii\helpers\ArrayHelper;
//
use thread\actions\fileapi\{
    DeleteAction, UploadAction
};
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
                    'path' => $this->module->getUploadPath() . 'article'
                ],
                'filedelete' => [
                    'class' => DeleteAction::class,
                    'path' => $this->module->getUploadPath() . 'article',
                ],
            ]
        );
    }
}
