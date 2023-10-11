<?php
namespace backend\modules\sys\modules\growl\controllers;

use yii\helpers\ArrayHelper;
//
use thread\app\base\controllers\BackendController;
use thread\actions\{
    Create, Update, AttributeSwitch
};
//
use backend\modules\sys\modules\growl\models\{
    Growl, search\Growl as filterGrowlModel
};

/**
 * Class RoleController
 *
 * @package backend\modules\sys\user\modules\controllers
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */
class GrowlController extends BackendController
{
    public $model = Growl::class;
    public $filterModel = filterGrowlModel::class;
    public $title = 'Growl';
    public $name = 'growl';

    public function actions()
    {
        return ArrayHelper::merge(parent::actions(), [
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
            ],
        ]);
    }
}
