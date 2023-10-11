<?php

use yii\db\Migration;
//
use common\modules\catalog\Catalog;

/**
 * Class m170721_132022_update_catalog_collection_lang_table
 */
class m170721_132022_update_catalog_collection_lang_table extends Migration
{
    /**
     * table name
     * @var string
     */
    public $tableLang = '{{%collection_lang}}';

    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->db = Catalog::getDb();
        parent::init();
    }

    /**
     * Implement migration
     */
    public function safeUp()
    {
        $this->renameColumn($this->tableLang, 'language_code', 'lang');

        $this->alterColumn($this->tableLang, 'lang', $this->string(5)->notNull()->comment('Language'));

        // change lang 'ru' on 'ru-RU'
        $this->update($this->tableLang, ['lang' => 'ru-RU'], ['lang' => 'ru']);

        $this->renameTable('collection_lang', 'catalog_collection_lang');
    }

    /**
     * Cancel migration
     */
    public function safeDown()
    {
        $this->renameTable('catalog_collection_lang', 'collection_lang');

        $this->renameColumn($this->tableLang, 'lang', 'language_code');
    }
}
