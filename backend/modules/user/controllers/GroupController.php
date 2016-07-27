<?php

namespace backend\modules\user\controllers;

use backend\modules\user\models\Group;
use thread\app\base\controllers\BackendController;
use thread\modules\user\models\GroupLang;

/**
 * Class GroupController
 *
 * @package admin\modules\user\controllers
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c) 2015, Thread
 */
class GroupController extends BackendController
{
    public $label = 'Group';
    public $title = "User groups";
    protected $model = Group::class;
    protected $modelLang = GroupLang::class;
}
