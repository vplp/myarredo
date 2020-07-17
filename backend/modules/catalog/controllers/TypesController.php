<?php

namespace backend\modules\catalog\controllers;

use yii\filters\AccessControl;
use thread\app\base\controllers\BackendController;
use backend\modules\catalog\models\{
    Types, TypesLang, search\Types as filterTypes
};

/**
 * Class TypesController
 *
 * @package backend\modules\catalog\controllers
 */
class TypesController extends BackendController
{
    public $model = Types::class;

    public $modelLang = TypesLang::class;

    public $filterModel = filterTypes::class;

    public $title = 'Предметы';

    public $name = 'subjects';

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
}
