<?php

namespace frontend\modules\user\widgets\partner;

use yii\base\Widget;
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
    public $defaultMarker = '/img/marker.png';

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

            $lat = $this->city['lat'];
            $lng = $this->city['lng'];
            $zoom = 10;
        } else {
            $partners = User::getPartners();

            $lat = 55.742130;
            $lng = 37.613583;
            $zoom = 3;
        }

        $dataJS = [];

        foreach ($partners as $k => $partner) {
            /** @var $partner User */
            $dataJS[$k]['lat'] = (float)$partner->profile->latitude;
            $dataJS[$k]['lng'] = (float)$partner->profile->longitude;
            $dataJS[$k]['address'] = $partner->profile->lang->address ?? '';
            $dataJS[$k]['city'] = isset($partner->profile->city) ? $partner->profile->city->getTitle() : '';
            $dataJS[$k]['country'] = isset($partner->profile->country) ? $partner->profile->country->getTitle() : '';
            $dataJS[$k]['phone'] = $partner->profile->partner_in_city ? $partner->profile->phone : '';
            $dataJS[$k]['image'] = $partner->profile->partner_in_city ? '/img/marker-main.png' : $this->defaultMarker;
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
