<?php

namespace frontend\modules\location\widgets;

use Yii;
use yii\base\Widget;
//
use frontend\modules\location\models\Currency;

/**
 * Class ChangeCurrency
 *
 * @package frontend\modules\location\widgets
 */
class ChangeCurrency extends Widget
{
    /**
     * @var string
     */
    public $view = 'change_currency';

    /**
     * @var string
     */
    public $current = '';

    /**
     * @var null
     */
    protected $items = null;


    /**
     * Init model for run method
     */
    public function init()
    {
        parent::init();

        $this->items = Currency::findBase()->all();

        $session = Yii::$app->session;

        if (!$session->has('currency') && Yii::$app->city->domain == 'ru') {
            $session->set('currency', 'RUB');
        } elseif (!$session->has('currency')) {
            $session->set('currency', 'EUR');
        }
    }

    /**
     * @return string
     */
    public function run()
    {
        $items = [];

        foreach ($this->items as $item) {
            if ($item['code2'] == Yii::$app->session->get('currency')) {
                $this->current = [
                    'label' => $item['code2'],
                    'url' => null,
                    'model' => $item,
                ];
            } else {
                $items[] = [
                    'label' => $item['code2'],
                    'url' => null,
                    'model' => $item,
                ];
            }
        }

        return $this->render(
            $this->view,
            [
                'current' => $this->current,
                'models' => $items,
            ]
        );
    }
}
