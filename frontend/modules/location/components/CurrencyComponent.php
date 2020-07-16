<?php

namespace frontend\modules\location\components;

use Yii;
use yii\base\Component;
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
            ? $this->model['currency_symbol']
            : '€';
    }

    /**
     * @return object
     */
    public function getCode()
    {
        return ($this->model != null)
            ? $this->model['code2']
            : 'EUR';
    }

    /**
     * @param $price
     * @param $code
     * @param string $thousand_sep
     * @return string
     * @throws \Throwable
     * @throws \yii\base\InvalidConfigException
     */
    public function getValue($price, $code, $thousand_sep = ' ')
    {
        if ($code != $this->model['code2'] && $this->model['code2'] == 'RUB') {
            $currency = Currency::findByCode2($code);
            $value = $price * $currency['course'];
        } elseif ($code != $this->model['code2']) {
            $currency = Currency::findByCode2($code);
            $value = $price * ($currency['course'] / $this->model['course']);
        } else {
            $value = $price;
        }

        return number_format(
            ceil($value),
            0,
            '.',
            $thousand_sep
        );
    }

    /**
     * @param $price
     * @param $codeFrom
     * @param $codeTo
     * @return string
     * @throws \Throwable
     * @throws \yii\base\InvalidConfigException
     */
    public function getReversValue($price, $codeFrom, $codeTo)
    {
        if ($codeFrom != $codeTo && $codeFrom != 'EUR') {
            $currencyFrom = Currency::findByCode2($codeFrom);
            $value = $price * ($currencyFrom['course'] / 100);
        } else {
            $value = $price;
        }

        return number_format(
            ceil($value),
            0,
            '.',
            ''
        );
    }
}
