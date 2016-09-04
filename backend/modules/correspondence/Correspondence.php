<?php
namespace backend\modules\correspondence;
/**
 * Class Сorrespondence
 *
 * @package backend\modules\correspondence
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */
class Correspondence extends \thread\modules\correspondence\Correspondence
{
    /**
     * Number of elements in GridView
     * @var int
     */
    public $itemOnPage = 20;
}
