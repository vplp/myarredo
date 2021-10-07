<?php

namespace backend\modules\sys\modules\logbook\controllers;

use backend\modules\sys\modules\logbook\models\{LogbookByMonth, search\LogbookByMonth as filterModel};
use thread\actions\{AttributeSwitch, Create, Update};
use thread\app\base\controllers\BackendController;
use yii\helpers\ArrayHelper;

/**
 * Class LogbookByMonthController
 *
 * @package backend\modules\sys\modules\logbook\controllers
 */
class LogbookByMonthController extends BackendController
{
    public $model = LogbookByMonth::class;
    public $filterModel = filterModel::class;
    public $title = 'Logbook';
    public $name = 'logbook';

    public function actions()
    {
        return ArrayHelper::merge(parent::actions(), [
            'list' => [
                'layout' => '/base',
            ],
        ]);
    }
}
