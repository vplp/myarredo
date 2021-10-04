<?php

namespace backend\modules\sys\modules\logbook\controllers;

use backend\modules\sys\modules\logbook\models\{Logbook, search\Logbook as filterModel};
use thread\actions\{AttributeSwitch, Create, Update};
use thread\app\base\controllers\BackendController;
use yii\helpers\ArrayHelper;

/**
 * Class LogbookController
 *
 * @package backend\modules\sys\modules\logbook\controllers
 */
class LogbookController extends BackendController
{
    public $model = Logbook::class;
    public $filterModel = filterModel::class;
    public $title = 'Logbook';
    public $name = 'logbook';

    public function actions()
    {
        return ArrayHelper::merge(parent::actions(), [
            'list' => [
                'layout' => '/base',
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

    public function actionListByMonth()
    {
        return $this->render(
            'list_by_month',
            [

            ]
        );
    }
}
