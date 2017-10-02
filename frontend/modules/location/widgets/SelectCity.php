<?php

namespace frontend\modules\location\widgets;

use Yii;
use yii\base\Widget;
use frontend\modules\location\models\{
    Country, City
};

/**
 * Class SelectCity
 *
 * @package frontend\modules\location\widgets
 */
class SelectCity extends Widget
{
    /**
     * @var string
     */
    public $view = 'select_city';

    /**
     * @var object
     */
    protected $country = [];

    /**
     * @var object
     */
    protected $city = [];

    /**
     * Init model for run method
     */
    public function init()
    {
        $session = Yii::$app->session;

        // get city name
        $cityAlias = str_replace(
            array(
                "www.myarredo2017.dev",
                ".myarredo2017.dev",
            ),
            "",
            $_SERVER["HTTP_HOST"]
        );

        if ($cityAlias) {
            $this->city = City::findByAlias($cityAlias);
        } else {
            $this->city = City::findByAlias('msk');
        }

        $this->country = Country::findById(2);

        $session->set('country', $this->country);
        $session->set('city', $this->city);
    }

    /**
     * @return string
     */
    public function run()
    {

        return $this->render(
            $this->view,
            [
                'country' => $this->country,
                'city' => $this->city
            ]
        );
    }
}