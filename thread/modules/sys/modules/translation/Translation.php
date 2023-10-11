<?php

namespace  thread\modules\sys\modules\translation;

use Yii;
use thread\app\base\module\abstracts\Module;
use thread\app\base\module\interfaces\Module as ModuleInterface;

/**
 * Class Translation
 *
 * @author Andrew Kontseba - Skinwalker <andjey.skinwalker@gmail.com>
 * @package thread\modules\sys\modules\translation
 */
class Translation extends Module implements ModuleInterface
{
    public $name = 'translation';
    public $configPath = __DIR__ . '/config.php';
    public $translationsBasePath = __DIR__ . '/messages';

    public static function t($message, $params = [], $language = null)
    {
        return Yii::t('thread\modules\sys', $message, $params, $language);
    }
}
