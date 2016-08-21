<?php
namespace frontend\modules\menu\widgets\menu;

use thread\app\base\widgets\Widget;
//
use frontend\modules\menu\models\{
    Menu, MenuItem
};

/**
 *
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */
class Menu extends Widget
{
    /**
     * @var string
     */
    public $view = 'menu';

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
        $menu = Menu::findByAlias($this->alias);
        if ($menu != null) {
            $this->items = MenuItem::findAllByGroup($menu['id']);
        }
    }

    /**
     *
     */
    public function run()
    {
        if ($this->items !== null) {
            return $this->render($this->view, ['items' => $this->items]);
        }
    }
}