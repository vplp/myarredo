<?php

namespace thread\modules\sys\modules\translation\components;

use Yii;
use yii\base\InvalidConfigException;
use yii\db\Expression;
use yii\db\Connection;
use yii\db\Query;
use yii\di\Instance;
use yii\caching\FileCache as Cache;
use yii\helpers\ArrayHelper;
use yii\i18n\MessageSource as BaseMessageSource;

/**
 * Class DbMessageSource
 *
 * @author Andrew Kontseba - Skinwalker <andjey.skinwalker@gmail.com> & resurtm <resurtm@gmail.com>
 * @package thread\modules\sys\modules\translation\components
 */
class DbMessageSource extends BaseMessageSource
{
    /**
     * Prefix which would be used when generating cache key.
     *
     * @deprecated This constant has never been used and will be removed in 2.1.0.
     */
    const CACHE_KEY_PREFIX = 'DbMessageSource';

    /**
     * @var Connection|array|string the DB connection object or the application component ID of the DB connection.
     *
     * After the DbMessageSource object is created, if you want to change this property, you should only assign
     * it with a DB connection object.
     *
     * Starting from version 2.0.2, this can also be a configuration array for creating the object.
     */
    public $db = 'db';
    /**
     * @var Cache|array|string the cache object or the application component ID of the cache object.
     * The messages data will be cached using this cache object.
     * Note, that to enable caching you have to set [[enableCaching]] to `true`, otherwise setting this property has no effect.
     *
     * After the DbMessageSource object is created, if you want to change this property, you should only assign
     * it with a cache object.
     *
     * Starting from version 2.0.2, this can also be a configuration array for creating the object.
     * @see cachingDuration
     * @see enableCaching
     */
    public $cache = 'cache';

    /**
     * @var string the name of the source message table.
     */
    public $sourceMessageTable = '{{%source_message}}';

    /**
     * @var string the name of the translated message table.
     */
    public $messageTable = '{{%message}}';

    /**
     * @var int the time in seconds that the messages can remain valid in cache.
     * Use 0 to indicate that the cached data will never expire.
     * @see enableCaching
     */
    public $cachingDuration = 0;

    /**
     * @var bool whether to enable caching translated messages
     */
    public $enableCaching = false;

    /**
     * Initializes the DbMessageSource component.
     * This method will initialize the [[db]] property to make sure it refers to a valid DB connection.
     * Configured [[cache]] component would also be initialized.
     *
     * @throws InvalidConfigException if [[db]] is invalid or [[cache]] is invalid.
     */
    public function init()
    {
        parent::init();
        $this->db = Instance::ensure($this->db, Connection::className());
        if ($this->enableCaching) {
            $this->cache = Instance::ensure($this->cache, Cache::className());
        }
    }

    /**
     * Loads the message translation for the specified language and category.
     * If translation for specific locale code such as `en-US` isn't found it
     * tries more generic `en`.
     *
     * @param string $category the message category
     * @param string $lang the target language
     * @return array the loaded messages. The keys are original messages, and the values
     * are translated messages.
     */
    protected function loadMessages($category, $lang)
    {
        if ($this->enableCaching) {
            $key = [
                __CLASS__,
                $category,
                $lang,
            ];
            $messages = Yii::$app->cache->get($key);

            if ($messages === false || empty($messages)) {
                $messages = $this->loadMessagesFromDb($category, $lang);
                Yii::$app->cache->set($key, $messages, $this->cachingDuration);
            }

            return $messages;
        } else {
            return $this->loadMessagesFromDb($category, $lang);
        }
    }

    /**
     * Loads the messages from database.
     * You may override this method to customize the message storage in the database.
     *
     * @param string $category the message category.
     * @param string $lang the target language.
     * @return array the messages loaded from database.
     */
    protected function loadMessagesFromDb($category, $lang)
    {
        $mainQuery = (new Query())->select(['key' => 't1.key', 'translation' => 't2.translation'])
            ->from(['t1' => $this->sourceMessageTable, 't2' => $this->messageTable])
            ->where([
                't1.published' => 1,
                't1.deleted' => 0,
                't1.id' => new Expression('[[t2.rid]]'),
                't1.category' => $category,
                't2.lang' => $lang,
            ]);

        $fallbackLang = substr($lang, 0, 2);
        $fallbackSourceLang = substr($this->sourceLanguage, 0, 2);

        if ($fallbackLang !== $lang) {
            $mainQuery->union($this->createFallbackQuery($category, $lang, $fallbackLang), true);
        } elseif ($lang === $fallbackSourceLang) {
            $mainQuery->union($this->createFallbackQuery($category, $lang, $fallbackSourceLang), true);
        }

        $messages = $mainQuery->createCommand($this->db)->queryAll();

        return ArrayHelper::map($messages, 'key', 'translation');
    }

    /**
     * The method builds the [[Query]] object for the fallback language messages search.
     * Normally is called from [[loadMessagesFromDb]].
     *
     * @param string $category the message category
     * @param string $lang the originally requested language
     * @param string $fallbackLanguage the target fallback language
     * @return Query
     * @see loadMessagesFromDb
     * @since 2.0.7
     */
    protected function createFallbackQuery($category, $lang, $fallbackLanguage)
    {
        return (new Query())->select(['key' => 't1.key', 'translation' => 't2.translation'])
            ->from(['t1' => $this->sourceMessageTable, 't2' => $this->messageTable])
            ->where([
                't1.id' => new Expression('[[t2.rid]]'),
                't1.category' => $category,
                't2.lang' => $fallbackLanguage,
            ])->andWhere([
                'NOT IN',
                't2.rid',
                (new Query())->select('[[id]]')->from($this->messageTable)->where(['lang' => $lang])
            ]);
    }

    /**
     * Clean cache.
     */
    public function cleanCache()
    {
        Yii::$app->cacheFrontend->flush();
    }
}
