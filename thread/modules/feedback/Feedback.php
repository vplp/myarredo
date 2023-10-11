<?php

namespace thread\modules\feedback;

use Yii;
//
use thread\app\base\module\abstracts\Module as aModule;

/**
 * Class Feedback
 *
 * @package thread\modules\feedback
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */
class Feedback extends aModule
{
    public $name = 'feedback';
    public $translationsBasePath = __DIR__ . '/messages';
    public $configPath = __DIR__ . '/config.php';

    /**
     * @return null|object
     * @throws \yii\base\InvalidConfigException
     */
    public static function getDb()
    {
        return Yii::$app->get('db-core');
    }
}
