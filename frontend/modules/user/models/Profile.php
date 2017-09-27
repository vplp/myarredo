<?php

namespace frontend\modules\user\models;

use frontend\modules\location\models\{
    City, Country
};

/**
 * Class Profile
 *
 * @package frontend\modules\user\models
 */
class Profile extends \common\modules\user\models\Profile
{
    /**
     * @return bool
     */
    public function getCountry()
    {
        $model = Country::findById($this->country_id);

        if ($model != null) {
            return $model['lang']['title'];
        }

        return false;
    }

    /**
     * @return bool
     */
    public function getCity()
    {
        $model = City::findById($this->city_id);

        if ($model != null) {
            return $model['lang']['title'];
        }

        return false;
    }
}
