<?php

namespace thread\app\model;

/**
 * class Language
 *
 * @package thread\app\model
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */
class Language implements interfaces\LanguageModel
{
    /**
     * @var array
     */
    public $items = [
        'en-EN' => [
            'by_default' => true,
            'alias' => 'en',
            'local' => 'en-EN',
            'label' => 'English',
        ],
        'uk-UA' => [
            'by_default' => false,
            'alias' => 'ua',
            'local' => 'uk-UA',
            'label' => 'Українська',
        ],
        'ru-RU' => [
            'by_default' => false,
            'alias' => 'ru',
            'local' => 'ru-RU',
            'label' => 'Русский',
        ],
        'it-IT' => [
            'by_default' => false,
            'alias' => 'it',
            'local' => 'it-IT',
            'label' => 'Italian',
        ],
        'de-DE' => [
            'by_default' => false,
            'alias' => 'de',
            'local' => 'de-DE',
            'label' => 'German',
        ],
    ];

    /**
     * @return array
     */
    public function getLanguages(): array
    {
        return $this->items;
    }

    /**
     * @return array
     */
    public function getCurrent(): array
    {
        return $this->items[\Yii::$app->language];
    }

    /**
     * @return array
     */
    public static function dropDownList()
    {
        $items = (new self())->getLanguages();
        foreach ($items as $key => $language) {
            $items[$key] = $language['label'];
        }
        return $items;
    }
}
