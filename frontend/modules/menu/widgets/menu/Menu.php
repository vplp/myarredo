<?php

namespace frontend\modules\menu\widgets\menu;

use thread\app\base\widgets\Widget;
use frontend\modules\menu\models\{
    Menu as ModelMenu, MenuItem
};

/**
 * Class Menu
 *
 * @package frontend\modules\menu\widgets\menu
 */
class Menu extends Widget
{
    /**
     * @var string
     */
    public $view = 'index';

    /**
     * @var string
     */
    public $name = 'menu';
    /**
     * @var string
     */
    public $alias = 'header';
    /**
     * @var null
     */
    protected $items = null;

    /**
     *
     */
    public function init()
    {
        $menu = ModelMenu::getByAlias($this->alias);
        if ($menu != null) {
            $this->items = MenuItem::getAllByGroup($menu['id'], 0);
        }
    }

    /**
     *
     */
    public function run()
    {
        if ($this->items != null) {
            return $this->render($this->view, [
                'items' => $this->items,
            ]);
        }
    }
}
