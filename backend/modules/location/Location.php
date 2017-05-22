<?php
namespace backend\modules\location;

/**
 * Class Location
 *
 * @package backend\modules\location
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */
class Location extends \common\modules\location\Location
{
    public $itemOnPage = 20;

    public $menuItems = [
        'name' => 'Location',
        'icon' => 'fa-map-marker',
        'position' => 7,
        'items' => [
            [
                'name' => 'Country',
                'icon' => 'fa-tasks',
                'url' => ['/location/country/list'],
            ],
            [
                'name' => 'City',
                'icon' => 'fa-tasks',
                'url' => ['/location/city/list'],
            ],
            [
                'name' => 'Currency',
                'icon' => 'fa-tasks',
                'url' => ['/location/currency/list'],
            ]
        ]
    ];
}
