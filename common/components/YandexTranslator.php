<?php

namespace common\components;

use yii\base\Component;
//
use Yandex\Translate\Translator;
use Yandex\Translate\Exception;

/**
 * Class SendPulse REST API
 *
 * @package common\components\sendpulse
 */
class YandexTranslator extends Component
{
    public $key;

    /**
     * Translates the text.
     *
     * @param string|array $text The text to be translated.
     * @param string $language Translation direction (for example, "en-ru" or "ru").
     *
     * @return string
     */
    public function getTranslate($text, $language)
    {
        try {
            $translator = new Translator($this->key);
            $translation = $translator->translate($text, $language);

            return (string)$translation;

        } catch (Exception $e) {
            // handle exception
            return false;
        }
    }
}
