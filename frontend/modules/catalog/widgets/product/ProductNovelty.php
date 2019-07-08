<?php

namespace frontend\modules\catalog\widgets\product;

use yii\base\Widget;

/**
 * Class ProductNovelty
 *
 * @package frontend\modules\catalog\widgets\product
 */
class ProductNovelty extends Widget
{
    /**
     * @var string
     */
    public $view = 'product_novelty';

    /**
     * @return string
     */
    public function run()
    {
        return $this->render($this->view, []);
    }
}
