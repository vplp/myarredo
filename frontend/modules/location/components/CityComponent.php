<?php

namespace frontend\modules\location\components;

use Yii;
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
    private $domain;

    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->setup();

        $this->setGeoMetaTags();

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
    public function getDomain()
    {
        return $this->domain;
    }

    /**
     * @return string
     */
    public function getPhoneMask()
    {
        if (in_array($this->domain, ['by'])) {
            $mask = '+375 (99) 999-99-99';
        } else if (in_array($this->domain, ['ua'])) {
            $mask = '+380 (99) 999-99-99';
        } else {
            $mask = '+7 (999) 999-99-99';
        }

        return $mask;
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

        $this->domain = $exp_host[1];

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

            if ($this->city == null || in_array($this->city['id'], [1, 2, 4])) {
                Yii::$app->response->redirect('http://' . 'www.myarredo.' . $this->domain . Yii::$app->request->url, 301);
                Yii::$app->end();
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
        if (in_array($this->domain, ['by'])) {
            // minsk
            $this->defaultCityId = 2;
        } else if (in_array($this->domain, ['ua'])) {
            // kiev
            $this->defaultCityId = 1;
        } else {
            // msk
            $this->defaultCityId = 4;
        }

        return $this->defaultCityId;
    }

    /**
     * Set geo meta tags
     */
    public function setGeoMetaTags()
    {
        Yii::$app->view->registerMetaTag([
            'name' => 'geo.region',
            'content' => $this->city['geo_region'],
        ]);
        Yii::$app->view->registerMetaTag([
            'name' => 'geo.placename',
            'content' => $this->city['geo_placename'],
        ]);
        Yii::$app->view->registerMetaTag([
            'name' => 'geo.position',
            'content' => $this->city['geo_position'],
        ]);
        Yii::$app->view->registerMetaTag([
            'name' => 'ICBM',
            'content' => $this->city['icbm'],
        ]);
    }
}