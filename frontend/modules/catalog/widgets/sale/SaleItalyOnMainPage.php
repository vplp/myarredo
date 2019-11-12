<?php

namespace frontend\modules\catalog\widgets\sale;

use yii\base\Widget;
//
use frontend\modules\catalog\models\{
    ItalianProduct, ItalianProductLang
};

/**
 * Class SaleItalyOnMainPage
 *
 * @package frontend\modules\catalog\widgets\sale
 */
class SaleItalyOnMainPage extends Widget
{
    /**
     * @var string
     */
    public $view = 'sale_italy_on_main_page';

    /**
     * @var object
     */
    protected $models = [];

    /**
     * Init model for run method
     */
    public function init()
    {
        $this->models = ItalianProduct::getDb()->cache(function ($db) {
            return ItalianProduct::findBaseArray()
                ->select([
                    ItalianProduct::tableName() . '.id',
                    ItalianProduct::tableName() . '.alias',
                    ItalianProduct::tableName() . '.image_link',
                    ItalianProduct::tableName() . '.factory_id',
                    ItalianProduct::tableName() . '.bestseller',
                    ItalianProduct::tableName() . '.price',
                    ItalianProduct::tableName() . '.price_new',
                    ItalianProduct::tableName() . '.currency',
                    ItalianProductLang::tableName() . '.title',
                ])
                ->limit(8)
                ->all();
        }, 3600);


        if ($this->models != null) {
            $i = 0;
            $_models = [];
            foreach ($this->models as $key => $model) {
                if ($key % 3 == 0) {
                    $i++;
                }
                $_models[$i][] = $model;
            }
            $this->models = $_models;
        }
    }

    /**
     * @return string
     */
    public function run()
    {
        if (!empty($this->models)) {
            return $this->render(
                $this->view,
                [
                    'models' => $this->models
                ]
            );
        }
    }
}
