<?php

namespace common\modules\rules;

use Yii;
//
use thread\app\base\module\abstracts\Module as aModule;

/**
 * Class RulesModule
 *
 * @package common\modules\rules
 */
class RulesModule extends aModule
{

    public $name = 'rules';
    public $configPath = __DIR__ . '/config.php';
    public $translationsBasePath = __DIR__ . '/messages';

    /**
     * @return object|string|null
     * @throws \yii\base\InvalidConfigException
     */
    public static function getDb()
    {
        return Yii::$app->get('db');
    }
}
