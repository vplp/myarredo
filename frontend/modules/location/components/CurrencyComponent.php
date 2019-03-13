<?php

namespace frontend\modules\location\components;

use Yii;
use yii\base\Component;
//
use frontend\modules\location\models\Currency;

/**
 * Class CurrencyComponent
 *
 * @package frontend\modules\location\components
 */
class CurrencyComponent extends Component
{
    protected $model = null;

    /**
     * @inheritdoc
     */
    public function init()
    {
        $session = Yii::$app->session;

        /**
         * Get current currency
         */
        if ($session->has('currency') && array_key_exists($session->get('currency'), Currency::getMapCode2Course())) {
            $this->model = Currency::findByCode2($session->get('currency'));
        }
    }

    /**
     * @return object
     */
    public function getSymbol()
    {
        return ($this->model != null)
            ? $this->model->currency_symbol
            : '€';
    }

    /**
     * @return object
     */
    public function getCode()
    {
        return ($this->model != null)
            ? $this->model->code2
            : 'EUR';
    }

    /**
     * @param $price
     * @return mixed
     */
    public function getValue($price)
    {
        $value = ($this->model != null)
            ? ($price / $this->model->course)
            : $price;

        return number_format(
            $price,
            2,
            '.',
            ''
        );
    }
}
