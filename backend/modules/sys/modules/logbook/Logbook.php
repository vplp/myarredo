<?php

namespace backend\modules\sys\modules\logbook;

/**
 * Class Logbook
 *
 * @package backend\modules\sys\modules\logbook
 */
class Logbook extends \thread\modules\sys\modules\logbook\Logbook
{
    /**
     * Number of elements in GridView
     * @var int
     */
    public $itemOnPage = 100;
}
