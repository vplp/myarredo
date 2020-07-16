<?php

namespace frontend\modules\location\components;

use Yii;
use yii\base\Component;
use frontend\modules\location\models\City;

/**
 * Class CityComponent
 *
 * @package frontend\modules\location\components
 */
class CityComponent extends Component
{
    /** @var integer */
    protected $defaultCityId = 0;

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
    public function getCountryId()
    {
        return $this->city['country_id'];
    }

    /**
     * @return integer
     */
    public function getCountryCode()
    {
        return $this->city['country']['alias'];
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
    public function isShowPrice()
    {
        return $this->city['show_price'];
    }

    /**
     * @return string
     */
    public function getDomain()
    {
        return $this->domain;
    }

    /**
     * @param null $key
     * @return mixed
     */
    public function getPhoneMask($key = null)
    {
        $mask = [
            'ua' => [
                '+380 (99) 999-99-99'
            ],
            'ru' => [
                '+7 (999) 999-99-99',
            ],
            'by' => [
                '+375 (99) 999-99-99'
            ],
            'it' => [
                '+39 (99) 999-999',
                '+39 (999) 999-999',
                '+39 (9999) 999-999',
                '+39 (9999) 999-9999'
            ],
            'de' => [
                '+39 (99) 999-999',
                '+39 (999) 999-999',
                '+39 (9999) 999-999',
                '+39 (9999) 999-9999'
            ],
        ];

        if (in_array($key, array_keys($mask))) {
            return $mask[$key];
        }

        if (!Yii::$app->getUser()->isGuest && Yii::$app->user->identity->group->role == 'factory') {
            return $mask['ru'] + $mask['it'];
        } elseif (Yii::$app->language == 'it-IT') {
            return $mask['it'];
        } elseif (in_array($this->domain, ['by'])) {
            return $mask['by'];
        } elseif (in_array($this->domain, ['ua'])) {
            return $mask['ua'];
        } else {
            return $mask['ru'];
        }
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

        // set domain
        $this->domain = (in_array($exp_host[1], ['ru', 'ua', 'by', 'com', 'de'])) ? $exp_host[1] : 'ru';

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

        if ($cityAlias && !in_array($this->domain, ['com', 'de'])) {
            $this->city = City::findByAlias($cityAlias);

            if ($this->city == null || in_array($this->city['id'], [1, 2, 4, 159, 160])) {
                Yii::$app->response->redirect(
                    'https://' . 'www.myarredo.' . $this->domain . Yii::$app->request->url,
                    301
                );
                Yii::$app->end();
            }

            if ($this->city['country']['alias'] != $this->domain) {
                Yii::$app->response->redirect(
                    'https://' . $this->city['alias'] . '.myarredo.' .
                    $this->city['country']['alias'] . Yii::$app->request->url,
                    301
                );
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
        } elseif (in_array($this->domain, ['ua'])) {
            // kiev
            $this->defaultCityId = 1;
        } elseif (in_array($this->domain, ['com'])) {
            // rome
            $this->defaultCityId = 159;
        } elseif (in_array($this->domain, ['de'])) {
            // berlin
            $this->defaultCityId = 160;
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
