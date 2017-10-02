<?php

namespace frontend\modules\location\widgets;

use Yii;
use yii\base\Widget;
use frontend\modules\location\models\{
    Country, City
};

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
        $session = Yii::$app->session;

        $this->country = Country::findById($session['country']['id']);
    }

    /**
     * @return string
     */
    public function run()
    {

        return $this->render(
            $this->view,
            [
                'country' => $this->country
            ]
        );
    }
}