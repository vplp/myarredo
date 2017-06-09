<?php

namespace thread\app\base\module\abstracts;

use Yii;
use yii\i18n\PhpMessageSource;
//
use thread\app\base\module\interfaces\Module as iModule;
use thread\app\base\i18n\TranslationEventHandler;

/**
 * Class Module
 *
 * @package thread\app\base\module
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */
abstract class Module extends \yii\base\Module implements iModule
{

    public $title;

    /**
     * Назва модуля
     * @var string
     */
    public $name = "module";

    /**
     * Шлях до каталогу з повідомленнями
     * @var string
     */
    public $translationsBasePath = '@thread/app/messages';

    /**
     *
     *     [
     *          'key' => [
     *              'class' => \yii\i18n\PhpMessageSource::class,
     *              'basePath' => $this->translationsBasePath,
     *              'fileMap' => [
     *                  'name' => 'app.php',
     *               ],
     *          ]
     *      ]
     *
     * @var array
     */
    public $translationsFileMap = [];

    /**
     * Шлях до файлу конфігурації
     * @var string
     */
    public $configPath = __DIR__ . '/config.php';

    /**
     *
     */
    public function init()
    {
        parent::init();
        if (is_file($this->configPath)) {
            Yii::configure($this, require(Yii::getAlias($this->configPath)));
        }

        $this->registerTranslations();

        if (empty($this->title)) {
            $this->title = $this->name;
        }
    }

    /**
     * Registers translations
     */
    public function registerTranslations()
    {

        Yii::$app->i18n->translations[$this->name] = [
            'class' => PhpMessageSource::class,
            'basePath' => $this->translationsBasePath,
            'fileMap' => [
                $this->name => 'app.php',
            ],
        ];

        if (!empty($this->translationsFileMap)) {
            foreach ($this->translationsFileMap as $maps_key => $maps) {
                Yii::$app->i18n->translations[$this->name . '-' . $maps_key] = $maps;
            }
        }
    }

    /**
     * Повертає об'єкт підключення до БД
     */
    public static function getDb()
    {
        return Yii::$app->get('db');
    }

    /**
     * Image upload path
     * @return string
     */
    public function getBaseUploadPath()
    {
        return Yii::getAlias('@uploads') . '/' . $this->name . '/';
    }

    /**
     * Image upload URL
     * @return string
     */
    public function getBaseUploadUrl()
    {
        //TODO Путь !!! при разработке учитывать
        return '/core-cms/web/uploads/' . $this->name . '/';
    }
}
