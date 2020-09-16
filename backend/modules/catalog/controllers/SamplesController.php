<?php

namespace backend\modules\catalog\controllers;

use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use common\actions\upload\{
    DeleteAction, UploadAction
};
use thread\app\base\controllers\BackendController;
use backend\modules\catalog\models\{
    Samples, SamplesLang, search\Samples as filterSamples
};

/**
 * Class SamplesController
 *
 * @package backend\modules\catalog\controllers
 */
class SamplesController extends BackendController
{
    public $model = Samples::class;
    public $modelLang = SamplesLang::class;
    public $filterModel = filterSamples::class;
    public $title = 'Samples';
    public $name = 'samples';

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
        return ArrayHelper::merge(
            parent::actions(),
            [
                'fileupload' => [
                    'class' => UploadAction::class,
                    'path' => $this->module->getSamplesUploadPath()
                ],
                'filedelete' => [
                    'class' => DeleteAction::class,
                    'path' => $this->module->getSamplesUploadPath()
                ],
            ]
        );
    }
}
