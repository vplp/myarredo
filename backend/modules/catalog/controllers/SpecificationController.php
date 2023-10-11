<?php

namespace backend\modules\catalog\controllers;

use yii\filters\AccessControl;
use thread\app\base\controllers\BackendController;
use backend\modules\catalog\models\{
    Specification, SpecificationLang, search\Specification as filterSpecification
};

/**
 * Class SpecificationController
 *
 * @package backend\modules\catalog\controllers
 */
class SpecificationController extends BackendController
{
    public $model = Specification::class;
    public $modelLang = SpecificationLang::class;
    public $filterModel = filterSpecification::class;
    public $title = 'Specification';
    public $name = 'specification';

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
