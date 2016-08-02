<?php
namespace backend\modules\menu\controllers;

use thread\app\base\controllers\BackendController;
//
use backend\modules\menu\models\{
    Menu, MenuLang, search\Menu as filterMenuModel
};

/**
 * @author Roman Gonchar <roman.gonchar92@gmail.com>
 */
class MenuController extends BackendController
{
    public $model = Menu::class;
    public $modelLang = MenuLang::class;
    public $filterModel = filterMenuModel::class;
    public $title = 'Menu';
}
