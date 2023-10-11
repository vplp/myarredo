<?php

use yii\db\Migration;
//
use common\modules\catalog\Catalog;

/**
 * Class m170721_120200_update_catalog_specification_lang_table
 */
class m170721_120200_update_catalog_specification_lang_table extends Migration
{
    /**
     * table lang name
     * @var string
     */
    public $tableLang = '{{%specification_lang}}';

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

        $this->renameTable('specification_lang', 'catalog_specification_lang');
    }

    /**
     * Cancel migration
     */
    public function safeDown()
    {
        $this->renameTable('catalog_specification_lang', 'specification_lang');

        $this->renameColumn($this->tableLang, 'lang', 'language_code');
    }
}
