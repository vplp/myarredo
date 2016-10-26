<?php

namespace thread\app\base\i18n;

use Yii;

/**
 * class I18N
 *
 * @package thread\app\base\i18n
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */
class I18N extends \yii\i18n\I18N
{
    protected $modulesApp = [];

    /**
     * @param string $category
     * @param string $message
     * @param array $params
     * @param string $language
     * @return string
     */
    public function translate($category, $message, $params, $language)
    {
        /**
         * register translation if is module
         */
        if (isset($this->modulesApp[$category]) && !isset($this->translations[$category])) {
            $this->registerModules($category);
        }
        /**
         * Set language themes if exists
         */
        $language = (\Yii::$app->params['themes']['language'])??$language;

        return parent::translate($category, $message, $params, $language);
    }

    /**
     *
     */
    public function init()
    {
        parent::init();
        $this->modulesApp = array_keys(Yii::$app->getModules());
    }

    /**
     * @param $category
     */
    public function registerModules($category)
    {
        Yii::$app->getModule($category)->registerTranslations();
    }
}
