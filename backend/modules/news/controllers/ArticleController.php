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
    Article, ArticleLang
};

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
