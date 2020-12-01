<?php

namespace backend\modules\seo\controllers;

use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use thread\app\base\controllers\BackendController;
use thread\actions\{
    Create, Update
};
use backend\modules\seo\models\{
    Redirects, search\Redirects as filterRedirectsModel
};

/**
 * Class RedirectsController
 *
 * @package backend\modules\seo\controllers
 */
class RedirectsController extends BackendController
{
    public $model = Redirects::class;
    public $filterModel = filterRedirectsModel::class;
    public $title = 'Redirects';
    public $name = 'redirects';

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

    public function actions()
    {
        return ArrayHelper::merge(parent::actions(), [
            'create' => [
                'class' => Create::class,
            ],
            'update' => [
                'class' => Update::class,
            ],
        ]);
    }
}
