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
        $event->translatedMessage = "@MISSING: {$event->category} \"{$event->message}\" FOR LANGUAGE {$event->language} @";
    }
}