<?php

namespace backend\modules\user\controllers;

use thread\app\base\controllers\BackendController;
//
use backend\modules\user\models\{
    Group, GroupLang, search\Group as filterGroupModel
};

/**
 * Class GroupController
 *
 * @package admin\modules\user\controllers
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */
class GroupController extends BackendController
{
    public $label = 'Group';
    public $title = "User groups";
    protected $model = Group::class;
    protected $modelLang = GroupLang::class;
    protected $filterModel = filterGroupModel::class;
}
