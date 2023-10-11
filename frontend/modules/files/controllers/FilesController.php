<?php

namespace backend\modules\files\controllers;

use yii\helpers\ArrayHelper;
use yii\filters\AccessControl;
use thread\actions\Update;
use thread\app\base\controllers\BackendController;
use common\actions\upload\{
    DeleteAction, UploadAction
};
//
use backend\modules\files\models\{
    Files, FilesLang, search\Files as SearchFiles
};

/**
 * Class FilesController
 *
 * @package backend\modules\files\controllers
 */
class FilesController extends BackendController
{
    public $title = 'Files';
    public $name = 'Files';
    public $model = Files::class;
    public $modelLang = FilesLang::class;
    public $filterModel = SearchFiles::class;

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
                'one-file-upload' => [
                    'class' => UploadAction::class,
                    'path' => $this->module->getArticleUploadPath(),
                    'uploadOnlyImage' => false,
                    'unique' => false
                ],
                'one-file-delete' => [
                    'class' => DeleteAction::class,
                    'path' => $this->module->getArticleUploadPath()
                ],
            ]
        );
    }
}   
