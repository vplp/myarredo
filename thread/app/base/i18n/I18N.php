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
        if (in_array($category, $this->modulesApp) && !isset($this->translations[$category])) {
            $this->registerModules($category);
        }
        /**
         * Set language themes if exists
         */
        $language = (\Yii::$app->params['themes']['language'])??$language;

        if (YII_ENV_DEV) {
            if (!$this->checkTranslateMessageExists($category, $message, $language)) {
                //TODO Not Complete
                echo 'Key does not exists : ' . $category . "->" . $message;
                $this->addNotExistMessageTOBase($category, $message, $language);
            }
        }

        return parent::translate($category, $message, $params, $language);
    }

    /**
     *
     */
    public function init()
    {
        parent::init();
        $this->initModulesApp();
    }

    /**
     *
     */
    public function initModulesApp()
    {
        $this->modulesApp = array_keys(Yii::$app->getModules());
    }

    /**
     * @param $category
     */
    public function registerModules($category)
    {
        Yii::$app->getModule($category)->registerTranslations();
    }

    /**
     * @param $category
     * @param $message
     * @param $language
     * @return bool
     * @throws \yii\base\InvalidConfigException
     */
    public function checkTranslateMessageExists($category, $message, $language)
    {
        $messageSource = $this->getMessageSource($category);
        $translation = $messageSource->translate($category, $message, $language);
        return ($translation === false) ? false : true;
    }

    /**
     * @param $category
     * @param $message
     * @param $language
     */
    public function addNotExistMessageTOBase($category, $message, $language)
    {
        //TODO Not Complete
    }
}
