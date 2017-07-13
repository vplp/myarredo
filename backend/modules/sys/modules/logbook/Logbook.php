<?php
namespace backend\modules\sys\modules\logbook;

/**
 * Class Logbook
 *
 * @package backend\modules\sys\modules\logbook
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */
class Logbook extends \common\modules\sys\modules\logbook\Logbook
{
    /**
     * Number of elements in GridView
     * @var int
     */
    public $itemOnPage = 20;
}
