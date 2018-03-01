<?php

namespace backend\modules\sys\modules\configs\controllers;

use yii\helpers\ArrayHelper;
//
use thread\app\base\controllers\BackendController;
//
use backend\modules\sys\modules\configs\models\{
    Group, GroupLang, search\Group as filterGroupModel
};

/**
 * Class GroupController
 *
 * @package backend\modules\sys\modules\configs\controllers
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */
class GroupController extends BackendController
{
    public $model = Group::class;
    public $modelLang = GroupLang::class;
    public $filterModel = filterGroupModel::class;
    public $title = 'Groups';
    public $name = 'group';

    public function actions()
    {

        return ArrayHelper::merge(parent::actions(), [
            'list' => [
                'layout' => 'list-group',
            ],
        ]);
    }
}
