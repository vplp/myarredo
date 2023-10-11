<?php

namespace frontend\modules\location\widgets;

use Yii;
use yii\base\Widget;
//
use frontend\modules\location\models\Country;

/**
 * Class Cities
 *
 * @package frontend\modules\location\widgets
 */
class Cities extends Widget
{
    /**
     * @var string
     */
    public $view = 'cities';

    /**
     * @var object
     */
    protected $country = [];

    /**
     * Init model for run method
     */
    public function init()
    {
        $city = Yii::$app->city->getCity();

        $this->country = Country::findById($city['country_id']);
    }

    /**
     * @return string
     */
    public function run()
    {
        if (isset($this->country['cities'])) {
            return $this->render(
                $this->view,
                [
                    'country' => $this->country
                ]
            );
        }
    }
}
