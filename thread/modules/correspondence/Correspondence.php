<?php

namespace thread\modules\correspondence;

use Yii;
//
use thread\app\base\module\abstracts\Module as aModule;

/**
 * Class Correspondence
 *
 * @package thread\modules\correspondence
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */
class Correspondence extends aModule
{
    public $name = 'correspondence';
    public $translationsBasePath = __DIR__ . '/messages';
    public $configPath = __DIR__ . '/config.php';
    public $userClass = null;

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        $this->userClass = $this->getUserClass();
    }

    /**
     * @return null|object
     * @throws \yii\base\InvalidConfigException
     */
    public static function getDb()
    {
        return Yii::$app->get('db-core');
    }

    /**
     * @return mixed
     */
    public static function getFormatDate()
    {
        return Yii::$app->getModule('correspondence')->params['format']['date'];
    }

    /**
     * Image upload path
     * @return string
     */
    public function getFileUploadPath()
    {
        return $this->getBaseUploadPath() . 'correspondence/';
    }

    /**
     * Image upload URL
     * @return string
     */
    public function getFileUploadUrl()
    {
        return $this->getBaseUploadUrl() . 'correspondence/';
    }

    /**
     * @return mixed
     */
    public function getUserClass()
    {
        return Yii::$app->getUser()->identityClass;
    }

   
}
