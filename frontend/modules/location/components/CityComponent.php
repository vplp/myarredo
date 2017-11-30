<?php

namespace frontend\modules\location\components;

use yii\base\Component;
//
use frontend\modules\location\models\City;

/**
 * Class CityComponent
 *
 * @package frontend\modules\location\components
 */
class CityComponent extends Component
{
    /** @var integer */
    protected $defaultCityId = 4;

    /** @var object */
    private $city;

    /** @var object */
    private $country;

    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->setup();

        parent::init();
    }

    /**
     * @return object
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * @return integer
     */
    public function getCityId()
    {
        return $this->city['id'];
    }

    /**
     * @return string
     */
    public function getCityTitle()
    {
        return $this->city['lang']['title'];
    }

    /**
     * @return string
     */
    public function getCountryTitle()
    {
        return $this->city['country']['lang']['title'];
    }

    /**
     * @return string
     */
    public function getCityTitleWhere()
    {
        return $this->city['lang']['title_where'];
    }

    /**
     * @inheritdoc
     */
    private function setup()
    {
        // get domain name
        $exp_host = explode('myarredo.', $_SERVER["HTTP_HOST"]);
        $this->country = $exp_host[1];
/* !!! */ echo  '<pre style="color:red;">'; print_r($this->country); echo '</pre>'; /* !!! */
        $exp_host = explode('.', $_SERVER['HTTP_HOST']);

        // get city name
        $cityAlias = str_replace(
            array(
                'www.' . $exp_host[1] . '.' . $exp_host[2],
                '.' . $exp_host[1] . '.' . $exp_host[2],
            ),
            "",
            $_SERVER["HTTP_HOST"]
        );

        if ($cityAlias) {
            $this->city = City::findByAlias($cityAlias);

            // TODO: need to be redone!

            if ($this->city == null) {
                $this->city = City::findById($this->defaultCityId);
            }
        } else {
            $this->city = City::findById($this->getDefaultCityId());
        }
    }

    /**
     * @return int
     */
    private function getDefaultCityId()
    {
        if ($this->country == 'by') {
            // minsk
            $this->defaultCityId = 2;
        } else if ($this->country == 'ua') {
            // kiev
            $this->defaultCityId = 1;
        } else {
            // msk
            $this->defaultCityId = 4;
        }

        return $this->defaultCityId;
    }
}