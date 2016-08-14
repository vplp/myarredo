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
            'default' => true,
            'alias' => 'en',
            'local' => 'en-EN',
            'label' => 'English',
        ],
        'uk-UA' => [
            'default' => false,
            'alias' => 'ua',
            'local' => 'uk-UA',
            'label' => 'Українська',
        ],
        'ru-RU' => [
            'default' => false,
            'alias' => 'ru',
            'local' => 'ru-RU',
            'label' => 'Русский',
        ],
    ];

    /**
     * @return array
     */
    public function getLanguages():array
    {
        return $this->items;
    }

    /**
     * @return array
     */
    public function getCurrent():array
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
