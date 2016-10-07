<?php
namespace backend\modules\sys\modules\crontab\controllers;

use yii\helpers\ArrayHelper;
//
use thread\app\base\controllers\BackendController;
use thread\actions\{
    Create, Update
};
//
use backend\modules\sys\modules\crontab\models\{
    Job, search\Job as filterJobModel
};

/**
 * Class JobController
 *
 * @package backend\modules\sys\modules\crontab\controllers
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */
class JobController extends BackendController
{
    public $model = Job::class;
    public $filterModel = filterJobModel::class;
    public $title = 'Job';
    public $name = 'job';

    public function actions()
    {
        return ArrayHelper::merge(parent::actions(), [
            'create' => [
                'class' => Create::class,
            ],
            'update' => [
                'class' => Update::class,
            ]
        ]);
    }
}
