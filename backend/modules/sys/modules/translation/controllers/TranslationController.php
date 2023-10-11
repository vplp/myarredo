<?php

namespace backend\modules\sys\modules\translation\controllers;

use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
//
use backend\modules\sys\modules\translation\models\{
    Message,
    Source,
    search\Source as SourceSearch
};
//
use thread\actions\EditableAttributeSaveLang;
use thread\app\base\controllers\BackendController;

/**
 * Class TranslationController
 *
 * @package backend\modules\sys\modules\translation\controllers
 */
class TranslationController extends BackendController
{
    public $model = Source::class;
    public $modelLang = Message::class;
    public $filterModel = SourceSearch::class;
    public $title = 'Translation';
    public $name = 'translation';

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
                        'roles' => ['admin'],
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
                'attribute-save' => [
                    'class' => EditableAttributeSaveLang::class,
                    'modelClass' => $this->modelLang,
                    'attribute' => 'translation',
                ]
            ]
        );
    }
}
