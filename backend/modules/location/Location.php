<?php

namespace backend\modules\location;

use Yii;

/**
 * Class Location
 *
 * @package backend\modules\location
 */
class Location extends \common\modules\location\Location
{
    public $itemOnPage = 100;

    public function getMenuItems()
    {
        $menuItems = [];

        if (in_array(Yii::$app->user->identity->group->role, ['admin'])) {
            $menuItems = [
                'label' => 'Location',
                'icon' => 'fa-map-marker',
                'position' => 7,
                'items' => [
                    [
                        'label' => 'Countries',
                        'icon' => 'fa-tasks',
                        'url' => ['/location/country/list'],
                    ],
                    [
                        'label' => 'Regions',
                        'icon' => 'fa-tasks',
                        'url' => ['/location/region/list'],
                    ],
                    [
                        'label' => 'Cities',
                        'icon' => 'fa-tasks',
                        'url' => ['/location/city/list'],
                    ],
                    [
                        'label' => 'Currency',
                        'icon' => 'fa-tasks',
                        'url' => ['/location/currency/list'],
                    ]
                ]
            ];
        }

        return $menuItems;
    }
}
