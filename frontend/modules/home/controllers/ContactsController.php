<?php

namespace frontend\modules\home\controllers;

use Yii;
use frontend\modules\user\models\User;
use frontend\components\BaseController;

/**
 * Class ContactsController
 *
 * @package frontend\modules\home\controllers
 */
class ContactsController extends BaseController
{
    public $title = "Партнеры сети MYARREDO";

    /**
     * @return string
     */
    public function actionIndex()
    {
        $city = Yii::$app->session['city'];

        $partners = User::getPartners($city['id']);

        $dataJS = [];

        foreach ($partners as $k => $obj) {
            $dataJS[$k]['lat'] = (float)$obj->profile->latitude;
            $dataJS[$k]['lng'] = (float)$obj->profile->longitude;
            $dataJS[$k]['address'] = $obj->profile->address;
            $dataJS[$k]['city'] = isset($obj->profile->city) ? $obj->profile->city->lang->title : '';
            $dataJS[$k]['country'] = isset($obj->profile->country) ? $obj->profile->country->lang->title : '';
            $dataJS[$k]['phone'] = 'phone';
        }

        return $this->render('contacts', array(
            'partners' => $partners,
            'city' => $city,
            'dataJS' => json_encode($dataJS),
        ));
    }

    /**
     * @return string
     */
    public function actionListPartners()
    {
        $this->title = "Все офисы продаж";

        $partners = User::getPartners();

        $dataJS = [];

        foreach ($partners as $k => $obj) {
            $dataJS[$k]['lat'] = (float)$obj->profile->latitude;
            $dataJS[$k]['lng'] = (float)$obj->profile->longitude;
            $dataJS[$k]['address'] = $obj->profile->address;
            $dataJS[$k]['city'] = isset($obj->profile->city) ? $obj->profile->city->lang->title : '';
            $dataJS[$k]['country'] = isset($obj->profile->country) ? $obj->profile->country->lang->title : '';
            $dataJS[$k]['phone'] = 'phone';
        }

        return $this->render('list_partners', array(
            'partners' => $partners,
            'dataJS' => json_encode($dataJS),
        ));
    }
}
