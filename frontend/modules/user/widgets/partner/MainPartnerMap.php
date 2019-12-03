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
        $zoom = 12;

        $dataJS = [];

        /** @var $partner User */
        $dataJS[0]['lat'] = (float)$partner->profile->latitude;
        $dataJS[0]['lng'] = (float)$partner->profile->longitude;
        $dataJS[0]['address'] = isset($partner->profile->lang) ? $partner->profile->lang->address : '';
        $dataJS[0]['city'] = isset($partner->profile->city) ? $partner->profile->city->lang->title : '';
        $dataJS[0]['country'] = isset($partner->profile->country) ? $partner->profile->country->lang->title : '';
        $dataJS[0]['phone'] = $partner->profile->phone;
        $dataJS[0]['image'] = $partner->profile->partner_in_city ? '/img/marker.png' : '/img/marker-main.png';

        if ($partner->profile->latitude2 && $partner->profile->longitude2 && $partner->profile->lang->address2) {
            $dataJS[1]['lat'] = (float)$partner->profile->latitude2;
            $dataJS[1]['lng'] = (float)$partner->profile->longitude2;
            $dataJS[1]['address'] = isset($partner->profile->lang) ? $partner->profile->lang->address2 : '';
            $dataJS[1]['city'] = isset($partner->profile->city) ? $partner->profile->city->lang->title : '';
            $dataJS[1]['country'] = isset($partner->profile->country) ? $partner->profile->country->lang->title : '';
            $dataJS[1]['phone'] = $partner->profile->phone;
            $dataJS[1]['image'] = $partner->profile->partner_in_city ? '/img/marker.png' : '/img/marker-main.png';
        }

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
