<?php
namespace thread\app\base\widgets;

use Yii;
use yii\i18n\PhpMessageSource;

/**
 * Class Widget
 *
 * @package thread\app\base
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */
abstract class Widget extends \yii\base\Widget
{
    /**
     * @var string
     */
    public $view = 'Widget';

    /**
     * @var string
     */
    public $name = 'widget';

    /**
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
     *
     */
    public function init()
    {
        parent::init();
        $this->registerTranslations();
    }
}
