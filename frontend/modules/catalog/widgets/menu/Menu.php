<?php

namespace frontend\modules\catalog\widgets\menu;

use Yii;
//
use thread\app\base\widgets\Widget;
//
use frontend\modules\catalog\models\Group;

/**
 * Class Menu
 *
 * @package frontend\modules\catalog\widgets\menu
 * @author Andrii Bondarchuk
 * @copyright (c) 2016
 */

class Menu extends Widget
{
    /**
     * @var string
     */
    public $view = 'header_menu';

    /**
     * @var string
     */
    public $addClass = '';

    /**
     * @var int
     */
    public $parent_id = 0;

    /**
     * @var object
     */
    protected $model = [];

    /**
     * @var object
     */
    protected $parent = [];

    /**
     * Init model for run method
     */
    public function init()
    {
        $this->model = Group::findByParentId($this->parent_id);

        $item = Group::findByAlias(Yii::$app->request->get('alias'));
        if ($item !== null) {
            $this->parent = $item->parent;
        }
    }

    /**
     * @return string
     */
    public function run()
    {
        return $this->render(
            $this->view,
            [
                'items' => $this->model,
                'addClass' => $this->addClass,
                'parent' => $this->parent,
            ]
        );
    }
}