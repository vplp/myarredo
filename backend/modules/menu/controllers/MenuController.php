<?php
namespace backend\modules\menu\controllers;

use thread\app\base\controllers\BackendController;
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
}
