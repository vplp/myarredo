<?php

namespace frontend\modules\user\widgets\partner;

use yii\base\Widget;
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
     * @var bool
     */
    public $city = false;

    /**
     * @return string
     */
    public function run()
    {
        // main partner
        $partner = User::findById($this->id);

        $lat = (float)$partner->profile->latitude;
        $lng = (float)$partner->profile->longitude;
        $zoom = 10;

        $dataJS = [];

        /** @var $partner User */
        $dataJS[0]['lat'] = (float)$partner->profile->latitude;
        $dataJS[0]['lng'] = (float)$partner->profile->longitude;
        $dataJS[0]['address'] = $partner->profile->lang->address ?? '';
        $dataJS[0]['city'] = isset($partner->profile->city) ? $partner->profile->city->getTitle() : '';
        $dataJS[0]['country'] = isset($partner->profile->country) ? $partner->profile->country->getTitle() : '';
        $dataJS[0]['phone'] = $partner->profile->phone;
        $dataJS[0]['image'] = $partner->profile->partner_in_city ? '/img/marker-main.png' : '/img/marker.png';

        if ($partner->profile->latitude2 && $partner->profile->longitude2 && isset($partner->profile->lang->address2)) {
            $dataJS[1]['lat'] = (float)$partner->profile->latitude2;
            $dataJS[1]['lng'] = (float)$partner->profile->longitude2;
            $dataJS[1]['address'] = $partner->profile->lang->address2 ?? '';
            $dataJS[1]['city'] = isset($partner->profile->city) ? $partner->profile->city->getTitle() : '';
            $dataJS[1]['country'] = isset($partner->profile->country) ? $partner->profile->country->getTitle() : '';
            $dataJS[1]['phone'] = $partner->profile->phone;
            $dataJS[1]['image'] = $partner->profile->partner_in_city ? '/img/marker-main.png' : '/img/marker.png';
        }

        // other partners
        if ($this->city) {
            $partners = User::getPartners($this->city['id']);

            $lat = $this->city['lat'];
            $lng = $this->city['lng'];
            $zoom = 10;
        }

        foreach ($partners as $partner) {
            /** @var $partner User */
            $dataJS[] = [
                'lat' => (float)$partner->profile->latitude,
                'lng' => (float)$partner->profile->longitude,
                'address' => $partner->profile->lang->address ?? '',
                'city' => isset($partner->profile->city) ? $partner->profile->city->getTitle() : '',
                'country' => isset($partner->profile->country) ? $partner->profile->country->getTitle() : '',
                'phone' => $partner->profile->partner_in_city ? $partner->profile->phone : '',
                'image' => $partner->profile->partner_in_city ? '/img/marker-main.png' : '/img/marker.png',
            ];
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
