<?php

namespace backend\modules\catalog\controllers;

use yii\filters\AccessControl;
use thread\app\base\controllers\BackendController;
use backend\modules\catalog\models\{
    Colors, ColorsLang, search\Colors as filterColors
};

/**
 * Class ColorsController
 *
 * @package backend\modules\catalog\controllers
 */
class ColorsController extends BackendController
{
    public $model = Colors::class;
    public $modelLang = ColorsLang::class;
    public $filterModel = filterColors::class;
    public $title = 'Colors';
    public $name = 'Colors';

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
