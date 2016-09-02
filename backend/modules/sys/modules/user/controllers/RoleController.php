<?php
namespace backend\modules\sys\modules\user\controllers;

use yii\helpers\ArrayHelper;
//
use thread\app\base\controllers\BackendController;
use thread\actions\{
    Create, Update
};
//
use backend\modules\sys\modules\user\models\{
    AuthRole, search\AuthRole as filterAuthRoleModel
};

/**
 * Class RoleController
 *
 * @package backend\modules\sys\user\modules\controllers
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */
class RoleController extends BackendController
{
    public $model = AuthRole::class;
    public $filterModel = filterAuthRoleModel::class;
    public $title = 'Role';
    public $name = 'role';

    public function actions()
    {
        return ArrayHelper::merge(parent::actions(), [
            'create' => [
                'class' => Create::class,
                'redirect' => function () {
                    return ($_POST['save_and_exit']) ? $this->actionListLinkStatus : [
                        'update',
                        'id' => $this->action->getModel()->name
                    ];
                }
            ],
            'update' => [
                'class' => Update::class,
                'redirect' => function () {
                    return ($_POST['save_and_exit']) ? $this->actionListLinkStatus : [
                        'update',
                        'id' => $this->action->getModel()->name
                    ];
                }
            ],
        ]);
    }
}
