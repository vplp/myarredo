<?php

namespace frontend\modules\user\widgets\partner;

use yii\base\Widget;
//
use frontend\modules\user\models\User;

/**
 * Class MainPartnerMap
 *
 * @package frontend\modules\user\widgets\partner
 */
class MainPartnerMap extends Widget
{
    /**
     * @var string
     */
    public $view = 'main_partner_map';

    /**
     * @var bool
     */
    public $id;

    /**
     * @return string
     */
    public function run()
    {
        $partner = User::findById($this->id);

        $lat = (float)$partner->profile->latitude;
        $lng = (float)$partner->profile->longitude;
        $zoom = 10;

        $dataJS = [];

        /** @var $partner User */
        $dataJS[]['lat'] = (float)$partner->profile->latitude;
        $dataJS[]['lng'] = (float)$partner->profile->longitude;
        $dataJS[]['address'] = isset($partner->profile->lang) ? $partner->profile->lang->address : '';
        $dataJS[]['city'] = isset($partner->profile->city) ? $partner->profile->city->lang->title : '';
        $dataJS[]['country'] = isset($partner->profile->country) ? $partner->profile->country->lang->title : '';
        $dataJS[]['phone'] = $partner->profile->phone;
        $dataJS[]['image'] = $partner->profile->partner_in_city ? '/img/marker-main.png' : '/img/marker.png';

        $dataJS = json_encode($dataJS);

        return $this->render(
            $this->view,
            [
                'zoom' => $zoom,
                'lat' => $lat,
                'lng' => $lng,
                'dataJS' => $dataJS,
            ]
        );
    }
}
