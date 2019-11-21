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
        $dataJS[0]['lat'] = (float)$partner->profile->latitude;
        $dataJS[0]['lng'] = (float)$partner->profile->longitude;
        $dataJS[0]['address'] = isset($partner->profile->lang) ? $partner->profile->lang->address : '';
        $dataJS[0]['city'] = isset($partner->profile->city) ? $partner->profile->city->lang->title : '';
        $dataJS[0]['country'] = isset($partner->profile->country) ? $partner->profile->country->lang->title : '';
        $dataJS[0]['phone'] = $partner->profile->phone;
        $dataJS[0]['image'] = $partner->profile->partner_in_city ? '/img/marker-main.png' : '/img/marker.png';

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
