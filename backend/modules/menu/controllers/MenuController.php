<?php

namespace backend\modules\menu\controllers;

use yii\helpers\ArrayHelper;
//
use thread\app\base\controllers\BackendController;
use thread\actions\EditableAttributeSave;
//
use backend\modules\menu\models\{
    Menu, MenuLang, search\Menu as filterMenuModel
};

/**
 * Class MenuController
 *
 * @package backend\modules\menu\controllers
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */
class MenuController extends BackendController
{
    public $model = Menu::class;
    public $modelLang = MenuLang::class;
    public $filterModel = filterMenuModel::class;
    public $title = 'Menu';
    public $name = 'menu';

    public function actions()
    {
        return ArrayHelper::merge(parent::actions(), [
            'attribute-save' => [
                'class' => EditableAttributeSave::class,
                'modelClass' => $this->model,
                'attribute' => 'alias'
            ],
        ]);
    }
}
