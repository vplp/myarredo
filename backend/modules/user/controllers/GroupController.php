<?php

namespace backend\modules\user\controllers;

use yii\helpers\ArrayHelper;
//
use thread\app\base\controllers\BackendController;
//
use backend\modules\user\models\{
    Group, GroupLang, search\Group as filterGroupModel
};

/**
 * Class GroupController
 *
 * @package admin\modules\user\controllers
 */
class GroupController extends BackendController
{
    public $title = "Groups";
    public $name = 'group';
    protected $model = Group::class;
    protected $modelLang = GroupLang::class;
    protected $filterModel = filterGroupModel::class;

    public function actions()
    {

        return ArrayHelper::merge(parent::actions(), [
            'list' => [
                'layout' => 'list-group',
            ],
        ]);
    }
}
