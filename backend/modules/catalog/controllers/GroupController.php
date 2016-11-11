<?php

namespace backend\modules\catalog\controllers;

use yii\helpers\ArrayHelper;
//
use thread\actions\fileapi\{
    DeleteAction, UploadAction
};
//
use thread\app\base\controllers\BackendController;
//
use backend\modules\catalog\models\{
    Group, GroupLang, search\Group as filterGroupModel
};

/**
 * Class GroupController
 *
 * @package backend\modules\catalog\controllers
 * @author Andrii Bondarchuk
 * @copyright (c) 2016, VipDesign
 */
class GroupController extends BackendController
{
    public $model = Group::class;
    public $modelLang = GroupLang::class;
    public $filterModel = filterGroupModel::class;
    public $title = 'Group';
    public $name = 'group';

    /**
     * @return array
     */
    public function actions()
    {
        return ArrayHelper::merge(
            parent::actions(),
            [
                'fileupload' => [
                    'class' => UploadAction::class,
                    'path' => $this->module->getBaseGroupUploadPath()
                ],
                'filedelete' => [
                    'class' => DeleteAction::class,
                    'path' => $this->module->getBaseGroupUploadPath()
                ],
            ]
        );
    }
}