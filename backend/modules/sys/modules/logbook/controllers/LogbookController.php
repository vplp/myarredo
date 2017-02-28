<?php
namespace backend\modules\sys\modules\logbook\controllers;

use yii\helpers\ArrayHelper;
//
use thread\app\base\controllers\BackendController;
use thread\actions\{
    Create, Update
};
//
use backend\modules\sys\modules\logbook\models\{
    Logbook, search\Logbook as filterModel
};

/**
 * Class LogbookController
 *
 * @package backend\modules\sys\modules\logbook\controllers
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
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
            'create' => [
                'class' => Create::class,
            ],
            'update' => [
                'class' => Update::class,
            ],
        ]);
    }
}
