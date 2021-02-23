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
                '+49 (99) 999-999',
                '+49 (999) 999-999',
                '+49 (9999) 999-999',
                '+49 (9999) 999-9999'
            ],
            'kz' => [
                '+39 (99) 999-999',
                '+39 (999) 999-999',
                '+39 (9999) 999-999',
                '+39 (9999) 999-9999'
            ],
            'he' => [
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
        } elseif (Yii::$app->language == 'de-DE') {
            return $mask['de'];
        } elseif (in_array(DOMAIN_TYPE, ['by'])) {
            return $mask['by'];
        } elseif (in_array(DOMAIN_TYPE, ['kz'])) {
            return $mask['kz'];
        } elseif (in_array(DOMAIN_TYPE, ['co.il'])) {
            return $mask['he'];
        } elseif (in_array(DOMAIN_TYPE, ['ua'])) {
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
     * @return string
     */
    public function getJivosite()
    {
        return $this->city['jivosite'];
    }

    /**
     * @inheritdoc
     */
    private function setup()
    {
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

        if ($cityAlias && !in_array(DOMAIN_TYPE, ['com', 'de', 'kz', 'co.il'])) {
            $this->city = City::findByAlias($cityAlias);

            if ($this->city == null || in_array($this->city['id'], [1, 2, 4, 159, 160, 161, 164])) {
                Yii::$app->response->redirect(
                    'https://' . 'www.' . DOMAIN_NAME . '.' . DOMAIN_TYPE . Yii::$app->request->url,
                    301
                );
                Yii::$app->end();
            }

            if ($this->city['country']['alias'] != DOMAIN_TYPE) {
                Yii::$app->response->redirect(
                    'https://' . $this->city['alias'] . '.' . DOMAIN_NAME . '.' .
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
        $lang = substr(Yii::$app->language, 0, 2);

        if (in_array(DOMAIN_TYPE, ['by'])) {
            // minsk
            $this->defaultCityId = 2;
        } elseif (in_array(DOMAIN_TYPE, ['ua'])) {
            // kiev
            $this->defaultCityId = 1;
        } elseif (in_array(DOMAIN_TYPE, ['com']) && DOMAIN_NAME == 'myarredofamily') {
            // washington
            $this->defaultCityId = 161;
        } elseif (in_array(DOMAIN_TYPE, ['com']) && DOMAIN_NAME == 'myarredo') {
            // rome
            $this->defaultCityId = 159;
        } elseif (in_array(DOMAIN_TYPE, ['de'])) {
            // berlin
            $this->defaultCityId = 160;
        } elseif (in_array(DOMAIN_TYPE, ['kz'])) {
            // nur-sultan
            $this->defaultCityId = 163;
        } elseif (in_array(DOMAIN_TYPE, ['co.il'])) {
            // jerusalem
            $this->defaultCityId = 164;
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
