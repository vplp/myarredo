<?php

namespace backend\modules\news\controllers;

use yii\helpers\ArrayHelper;
//
use thread\actions\AttributeSwitch;
use thread\actions\EditableAttributeSaveLang;
use thread\app\base\controllers\BackendController;
//
use backend\modules\news\models\{
    ArticleForPartners,
    ArticleForPartnersLang,
    search\ArticleForPartners as filterArticleForPartnersModel
};

/**
 * Class ArticleForPartnersController
 *
 * @package backend\modules\news\controllers
 */
class ArticleForPartnersController extends BackendController
{
    public $model = ArticleForPartners::class;
    public $modelLang = ArticleForPartnersLang::class;
    public $filterModel = filterArticleForPartnersModel::class;
    public $title = 'Information for partners';
    public $name = 'Information for partners';

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
                ],
                'show_all' => [
                    'class' => AttributeSwitch::class,
                    'modelClass' => $this->model,
                    'attribute' => 'show_all',
                    'redirect' => $this->defaultAction,
                ],
            ]
        );
    }
}
