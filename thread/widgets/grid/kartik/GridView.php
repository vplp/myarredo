<?php

namespace thread\widgets\grid\kartik;

use kartik\grid\GridView as kGridView;

/**
 * Class GridView
 *
 * @package backend\components\grid\kartik
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c) 2015, VipDesign
 */
class GridView extends kGridView
{
    /**
     * @var string
     */
    public $id = 'grid';

    /**
     * @var bool
     */
    public $export = false;

    /**
     * @var bool
     */
    public $bootstrap = true;

    /**
     * @var bool
     */
    public $responsive = true;

    /**
     * @var bool
     */
    public $hover = true;

    /**
     * @var bool
     */
    public $toolbar = false;

    /**
     * @var array
     */
    public $panel = [
        'type' => GridView::TYPE_DEFAULT,
        'before' => '',
        'footer' => false,
    ];
}
