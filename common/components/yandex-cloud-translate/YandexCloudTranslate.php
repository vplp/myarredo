<?php

namespace common\components\yandex;

use yii\base\Component;

/**
 * Class YandexCloudTranslate
 *
 * @package common\components
 */
class YandexCloudTranslate extends Component
{
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
