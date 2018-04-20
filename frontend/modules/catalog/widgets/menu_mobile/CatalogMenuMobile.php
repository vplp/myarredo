<?php

namespace frontend\modules\catalog\widgets\menu_mobile;

use yii\base\Widget;
use frontend\modules\catalog\models\Category;

/**
 * Class CatalogMenu
 *
 * @package frontend\modules\catalog\widgets\menu_mobile
 */
class CatalogMenuMobile extends Widget
{
    /**
     * @var string
     */
    public $view = 'catalog_menu_mobile';

    /**
     * @var object
     */
    protected $category = [];

    /**
     * Init model for run method
     */
    public function init()
    {
        $this->category = Category::getWithProduct();
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