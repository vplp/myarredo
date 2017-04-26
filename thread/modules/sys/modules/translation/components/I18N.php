<?php

namespace thread\modules\sys\modules\translation\components;

use yii\i18n\I18N as BaseI18N;
use yii\i18n\MissingTranslationEvent;
//
use thread\modules\sys\modules\translation\models\Message;
use thread\modules\sys\modules\translation\models\Source;

/**
 * Class I18N
 *
 * @author Andrew Kontseba - Skinwalker <andjey.skinwalker@gmail.com>
 * @package thread\modules\sys\modules\translation\components
 */
class I18N extends BaseI18N
{
    /** @var string */
    public $db = 'db';

    /** @var Source $sourceModel */
    public $sourceModel = Source::class;

    /** @var Message $messageModel */
    public $messageModel = Message::class;

    /** @var array */
    public $missingTranslation = ['\thread\modules\sys\modules\translation\components\I18N', 'missingTranslation'];

    /** @var string */
    public $languageModel;

    /** @var array */
    public $languages;

    /** @var bool  */
    public $enableCaching = false;

    /** @var int  */
    public $cachingDuration = 3600;

    /**
     * Get translates from db and redirect to missingTranslation if key not exist.
     */
    public function init()
    {
        $sourceTable = $this->sourceModel::tableName();

        $messageTable = $this->messageModel::tableName();

        if (!isset($this->translations['*'])) {
            $this->translations['*'] = [
                'class' => DbMessageSource::className(),
                'db' => $this->db,
                'sourceMessageTable' => $sourceTable,
                'messageTable' => $messageTable,
                'on missingTranslation' => $this->missingTranslation,
                'enableCaching' => $this->enableCaching,
                'cachingDuration' => $this->cachingDuration,
            ];
        }
        if (!isset($this->translations['app']) && !isset($this->translations['app*'])) {
            $this->translations['app'] = [
                'class' => DbMessageSource::className(),
                'db' => $this->db,
                'sourceMessageTable' => $sourceTable,
                'messageTable' => $messageTable,
                'on missingTranslation' => $this->missingTranslation,
                'enableCaching' => $this->enableCaching,
                'cachingDuration' => $this->cachingDuration,
            ];
        }
        parent::init();
    }

    /**
     * Check key exist, and write new if not.
     *
     * @param \yii\i18n\MissingTranslationEvent $event
     */
    public static function missingTranslation(MissingTranslationEvent $event)
    {
        $class = get_called_class();
        $sourceModel = (new $class)->sourceModel;

        /** @var Source $sourceModel */
        if (!$sourceModel::existKey($event->category, $event->message)) {

            /** @var Source $model */
            $model = new $sourceModel;
            $model->setScenario('backend');

            $model->category = $event->category;
            $model->key = $event->message;

            if (!$model->save(true)) {
                var_dump($model->getErrors());
            }
        }

        $event->translatedMessage = "@MISSING: KEY: {$event->category} MESS: \"{$event->message}\" FOR LAN {$event->language} @";
    }
}
