<?php

namespace backend\modules\sys\modules\logbook\controllers;

use backend\modules\sys\modules\logbook\models\{LogbookAuth, search\LogbookAuth as filterModel};
use thread\actions\{AttributeSwitch, Create, Update};
use thread\app\base\controllers\BackendController;
use yii\helpers\ArrayHelper;

/**
 * Class LogbookAuthController
 *
 * @package backend\modules\sys\modules\logbook\controllers
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */
class LogbookAuthController extends BackendController
{
    public $model = LogbookAuth::class;
    public $filterModel = filterModel::class;
    public $title = 'Logbook';
    public $name = 'logbook';

    public function actions()
    {
        return ArrayHelper::merge(parent::actions(), [
            'list' => [
                'layout' => 'crud',
            ],
            'create' => [
                'class' => Create::class,
            ],
            'update' => [
                'class' => Update::class,
            ],
            'is_read' => [
                'class' => AttributeSwitch::class,
                'modelClass' => $this->model,
                'attribute' => 'is_read',
                'redirect' => $this->defaultAction,
                'useLog' => false
            ],
        ]);
    }

}
