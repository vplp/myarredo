<?php

namespace backend\modules\news\controllers;

use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use thread\app\base\controllers\BackendController;
use backend\modules\news\models\{
    Group, GroupLang, search\Group as filterGroupModel
};

/**
 * Class GroupController
 *
 * @package backend\modules\news\controllers
 */
class GroupController extends BackendController
{
    public $model = Group::class;
    public $modelLang = GroupLang::class;
    public $filterModel = filterGroupModel::class;
    public $title = 'Groups';
    public $name = 'group';

    /**
     * @return array
     */
    public function behaviors()
    {
        return [
            'AccessControl' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['error'],
                        'roles' => ['?', '@'],
                    ],
                    [
                        'allow' => true,
                        'roles' => ['admin', 'catalogEditor'],
                    ],
                    [
                        'allow' => false,
                    ],
                ],
            ],
        ];
    }

    /**
     * @return array|array[]
     */
    public function actions()
    {
        return ArrayHelper::merge(parent::actions(), [
            'list' => [
                'layout' => 'list-group',
            ],
        ]);
    }
}
