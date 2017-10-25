<?php

namespace frontend\modules\home\controllers;

use frontend\modules\user\User;
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
        return $this->render('index');
    }

    /**
     * Карта партнеров (ЯНДЕКСА)
     */
    public function actionListPartners()
    {
        $this->title = "Все офисы продаж";

        //$partners = User::

        $dataJS = array();
//        foreach ($partners as $k => $obj) {
//            $dataJS[$k][] = (float)$obj->userData->latitude;
//            $dataJS[$k][] = (float)$obj->userData->longitude;
//            $dataJS[$k][] = $obj->userData->city->name;
//            $dataJS[$k][] = $obj->userData->address;
//            $dataJS[$k][] = 'test';//isset($obj->userData->country->name) ? $obj->userData->country->name : '';
//        }
//
//        $this->pageTitle = "Все офисы продаж";
//        $first = Variable::getValue('first');
//        $second = Variable::getValue('second');
//        $description = $first . ' ' . $this->pageTitle . '. ' . $second;
//        Yii::app()->clientScript->registerMetaTag($description, 'description');

        return $this->render('list_partners', array(
//            'model' => $partners,
            'dataJS' => $dataJS,
        ));
    }
}
