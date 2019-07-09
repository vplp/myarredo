<?php

namespace frontend\modules\catalog\widgets\menu_mobile;

use yii\base\Widget;

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
     * @return string
     */
    public function run()
    {
        return $this->render($this->view, []);
    }
}
