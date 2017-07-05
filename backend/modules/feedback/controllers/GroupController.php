<?php

namespace backend\modules\feedback\controllers;

use yii\helpers\ArrayHelper;
//
use thread\app\base\controllers\BackendController;
//
use backend\modules\feedback\models\{
    Group, GroupLang, search\Group as filterGroupModel
};

/**
 * Class GroupController
 *
 * @package backend\modules\feedback\controllers
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
