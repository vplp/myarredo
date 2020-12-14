<?php

namespace frontend\modules\location\widgets;

use Yii;
use yii\base\Widget;
use frontend\modules\location\models\{
    Country
};

/**
 * Class ChangeCity
 *
 * @package frontend\modules\location\widgets
 */
class ChangeCity extends Widget
{
    /**
     * @var string
     */
    public $view = 'select_city';

    /**
     * @var object
     */
    public $country = [];

    /**
     * @var object
     */
    public $city = [];

    /**
     * Init model for run method
     */
    public function init()
    {
        $this->city = Yii::$app->city->getCity();

        $this->country = Country::findById($this->city['country']['id']);
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
