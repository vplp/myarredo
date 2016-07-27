<?php

namespace thread\modules\location\widgets;

use frontend\components\SessionHelper;
use Yii;
use yii\web\Cookie;
use thread\modules\location\models\Currency;

/**
 * Class CurrencySwitch
 *
 * @package thread\location\widgets
 *
 * <?= CurrencySwitch::widget();?>
 *
 */
class CurrencySwitch extends \yii\bootstrap\Widget
{
    const COURSE_PARAM = 'currency';

    /**
     * @var string
     */
    public $current = 'RUR';

    /**
     * @var array
     */
    protected $items = null;

    /**
     * @var string
     */
    public $currencyCookieName = '_currency';

    /**
     * @var integer
     */
    public $cookieExpire;

    /**
     * @var string
     */
    public $cookieDomain;

    /**
     * @var string
     */
    public $view = 'CurrencySwitch';

    /**
     * @var \Closure
     */
    public $callback;

    public function init()
    {
        $this->items = Currency::getList();
        $this->current = $this->getCurrent();

        if ((isset($this->items[$this->current]->id ))) {
            Yii::$app->controller->currentCourseId = $this->items[$this->current]->id;
            SessionHelper::setCourseId($this->items[$this->current]->id);
        }
    }

    public function run()
    {
        if (Yii::$app->request->get('currency')) {
            $this->setCurrent(Yii::$app->request->get('currency'));

            // redirect
            Yii::$app->getResponse()->redirect(Yii::$app->request->referrer);

            return '';
        }

        $items = [];

        $current = $this->items[$this->current];
        unset($this->items[$this->current]);

        foreach ($this->items as $item) {
            $items[] = ['label' => $item->title];
        }

//        /**/ echo '<pre style="color: red">'; print_r($current); echo '</pre>'; die(); /**/


        return $this->render($this->view, [
            'current' => $current,
            'items' => $items,
        ]);
    }

    private function getCurrent()
    {
        $cookie = Yii::$app->request->cookies[$this->currencyCookieName];

        if ($cookie !== null) {
            $value = $cookie->value;
        } else {
            $this->setCurrent($this->current);

            $value = $this->current;
        }

        return $value;
    }

    private function setCurrent($value)
    {
        $cookie = new Cookie([
            'name' => $this->currencyCookieName,
            'value' => $value,
            'expire' => $this->cookieExpire ?: time() + 60 * 60 * 24 * 365,
            'domain' => $this->cookieDomain ?: '',
        ]);

        // add
        Yii::$app->getResponse()->getCookies()->add($cookie);
    }
}
