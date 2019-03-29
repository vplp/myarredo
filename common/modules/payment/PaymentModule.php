<?php

namespace common\modules\payment;

use Yii;
//
use thread\app\base\module\abstracts\Module as aModule;

/**
 * Class PaymentModule
 *
 * @package common\modules\payment
 */
class PaymentModule extends aModule
{

    public $name = 'payment';
    public $configPath = __DIR__ . '/config.php';
    public $translationsBasePath = __DIR__ . '/messages';

    /**
     * @return null|object|string
     * @throws \yii\base\InvalidConfigException
     */
    public static function getDb()
    {
        return Yii::$app->get('db');
    }

    /**
     * @return mixed
     */
    public static function getFormatDate()
    {
        return Yii::$app->getModule('payment')->params['format']['date'];
    }
}
