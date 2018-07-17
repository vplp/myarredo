<?php

namespace frontend\modules\user\widgets\partner;

use yii\base\Widget;
//
use frontend\modules\user\models\User;

/**
 * Class PartnerMap
 *
 * @package frontend\modules\user\widgets\partner
 */
class PartnerMap extends Widget
{
    /**
     * @var string
     */
    public $view = 'partner_map';

    /**
     * @var bool
     */
    public $city = false;

    /**
     * @return string
     */
    public function run()
    {
        if ($this->city) {
            $partners = User::getPartners($this->city['id']);

            $lat = $this->city->lat;
            $lng = $this->city->lng;
            $zoom = 10;
        } else {
            $partners = User::getPartners();

            $lat = 55.742130;
            $lng = 37.613583;
            $zoom = 4;
        }

        $dataJS = [];

        foreach ($partners as $k => $obj) {
            /** @var $obj User */
            $dataJS[$k]['lat'] = (float)$obj->profile->latitude;
            $dataJS[$k]['lng'] = (float)$obj->profile->longitude;
            $dataJS[$k]['address'] = $obj->profile->address;
            $dataJS[$k]['city'] = isset($obj->profile->city) ? $obj->profile->city->lang->title : '';
            $dataJS[$k]['country'] = isset($obj->profile->country) ? $obj->profile->country->lang->title : '';
            $dataJS[$k]['phone'] = $obj->profile->phone;
            $dataJS[$k]['image'] = $obj->profile->partner_in_city ? '/img/marker-main.png' : '/img/marker.png';
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