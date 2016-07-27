<?php
namespace backend\modules\menu\controllers;

use backend\modules\menu\models\search\Menu;
use backend\modules\menu\models\MenuLang;
use thread\app\base\controllers\BackendController;

/**
 * @author Roman Gonchar <roman.gonchar92@gmail.com>
 */
class MenuController extends BackendController
{
    public $model = Menu::class;
    public $modelLang = MenuLang::class;
    public $title = 'Menu';
}
