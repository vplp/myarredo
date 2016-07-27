<?php
namespace backend\modules\news\controllers;

use thread\actions\fileapi\DeleteAction;
use Yii;
use backend\modules\news\models\search\Article;
use backend\modules\news\models\ArticleLang;
use thread\actions\fileapi\UploadAction;
use thread\app\base\controllers\BackendController;
use yii\helpers\ArrayHelper;

/**
 * @author Roman Gonchar <roman.gonchar92@gmail.com>
 */
class ArticleController extends BackendController
{
    public $model = Article::class;
    public $modelLang = ArticleLang::class;
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
                    'path' => Yii::$app->getModule('news')->getUploadPath() . 'article'
                ],
                'filedelete' => [
                    'class' => DeleteAction::class,
                    'path' => Yii::$app->getModule('news')->getUploadPath() . 'article',
                ],
            ]
        );
    }
}
