<?php

namespace frontend\modules\catalog;

/**
 * Class Catalog
 *
 * @package frontend\modules\catalog
 * @author Andrii Bondarchuk
 * @copyright (c) 2016
 */
class Catalog extends \common\modules\catalog\Catalog
{
    /**
     * Number of elements in GridView
     * @var int
     */
    public $itemOnPage = 6;
}
