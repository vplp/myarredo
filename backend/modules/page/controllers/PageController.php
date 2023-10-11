<?php

namespace backend\modules\page\controllers;

use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
//
use thread\actions\EditableAttributeSaveLang;
use thread\app\base\controllers\BackendController;
//
use backend\modules\page\models\{
    Page, PageLang, search\Page as filterPageModel
};

/**
 * Class PageController
 *
 * @package backend\modules\page\controllers
 */
class PageController extends BackendController
{
    public $model = Page::class;
    public $modelLang = PageLang::class;
    public $filterModel = filterPageModel::class;
    public $title = 'Pages';
    public $name = 'page';

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
                'attribute-save' => [
                    'class' => EditableAttributeSaveLang::class,
                    'modelClass' => $this->modelLang,
                    'attribute' => 'title',
                ]
            ]
        );
    }
}
