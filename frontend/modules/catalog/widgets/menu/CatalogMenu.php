<?php

namespace frontend\modules\catalog\widgets\menu;

use Yii;
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
     * @var object
     */
    protected $categorySale = [];

    /**
     * @var object
     */
    protected $categorySaleItaly = [];

    /**
     * Init model for run method
     */
    public function init()
    {
        /**
         * Product
         */
        $this->category = Category::getWithProduct();

        /**
         * Sale
         */
        $queryParams = [];
        $queryParams['country'] = Yii::$app->city->getCountryId();

        $this->categorySale = Category::getWithSale($queryParams);

        /**
         * SaleItaly
         */
        $this->categorySaleItaly = Category::getWithItalianProduct();
    }

    /**
     * @return string
     */
    public function run()
    {
        return $this->render(
            $this->view,
            [
                'category' => $this->category,
                'categorySale' => $this->categorySale,
                'categorySaleItaly' => $this->categorySaleItaly
            ]
        );
    }
}
