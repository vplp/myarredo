<?php

namespace frontend\modules\catalog\widgets\menu;

use yii\base\Widget;
use frontend\modules\catalog\models\Category;

/**
 * Class CatalogMenu
 *
 * @package frontend\modules\catalog\widgets\menu
 */
class CatalogMenu extends Widget
{
    /**
     * @var string
     */
    public $view = 'catalog_menu';

    /**
     * @var object
     */
    protected $category = [];

    /**
     * Init model for run method
     */
    public function init()
    {
        $this->category = Category::getWithProduct(); //findBase()->all()
    }

    /**
     * @return string
     */
    public function run()
    {
        return $this->render(
            $this->view,
            [
                'category' => $this->category
            ]
        );
    }
}