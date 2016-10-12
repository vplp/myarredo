<?php

namespace backend\modules\catalog;

/**
 * Class Catalog
 *
 * @package backend\modules\catalog
 * @author Andrii Bondarchuk
 * @copyright (c) 2016, VipDesign
 */
class Catalog extends \common\modules\catalog\Catalog
{
    /**
     * Number of elements in GridView
     * @var int
     */
    public $itemOnPage = 20;
}
