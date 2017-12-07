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
    public $itemOnPage = 20;

    public function getMenuItems()
    {
        $menuItems = [];

        if (in_array(Yii::$app->getUser()->getIdentity()->group->role, ['admin'])) {
            $menuItems = [
                'name' => 'Location',
                'icon' => 'fa-map-marker',
                'position' => 7,
                'items' => [
                    [
                        'name' => 'Countries',
                        'icon' => 'fa-tasks',
                        'url' => ['/location/country/list'],
                    ],
                    [
                        'name' => 'Cities',
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

        return $menuItems;
    }
}
