<?php

namespace thread\app\base\i18n;

use yii\i18n\MissingTranslationEvent;

/**
 * Class TranslationEventHandler
 *
 * @package thread\app\base\i18n
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */
class TranslationEventHandler
{
    public static function handleMissingTranslation(MissingTranslationEvent $event)
    {
//        var_dump($event->sender);

        $event->translatedMessage = "@MISSING: KEY: {$event->category} MESS: \"{$event->message}\" FOR LAN {$event->language} @";
    }
}