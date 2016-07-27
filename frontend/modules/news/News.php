<?php

namespace frontend\modules\news;

/**
 * Class News
 *
 * @package frontend\modules\news*
 * @author Andrii Bondarchuk
 * @copyright (c) 2016
 */
class News extends \backend\modules\news\News {
    /**
     * Number of elements in GridView
     * @var int
     */
    public $itemOnPage = 6;
}
