<?php

namespace backend\modules\catalog\controllers;

use yii\helpers\ArrayHelper;
use yii\filters\AccessControl;
use backend\modules\catalog\models\{
    Composition,
    CompositionLang,
    search\Product as filterProduct
};
use thread\actions\ListModel;
use thread\app\base\controllers\BackendController;

/**
 * Class CompositionTranslationController
 *
 * @package backend\modules\catalog\controllers
 */
class CompositionTranslationController extends BackendController
{
    public $model = Composition::class;
    public $modelLang = CompositionLang::class;
    public $filterModel = filterProduct::class;

    public $title = 'Composition translation';

    public $name = 'Composition translation';

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
                        'roles' => ['admin', 'catalogEditor'],
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
        return ArrayHelper::merge(parent::actions(), [
            'list' => [
                'class' => ListModel::class,
                'modelClass' => $this->model,
                'layout' => 'list-countries-furniture'
            ],
            'create' => null,
            'update' => [
                'scenario' => 'translation'
            ],
        ]);
    }
}
