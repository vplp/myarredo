<?php

use yii\db\Migration;
//
use common\modules\catalog\Catalog;

/**
 * Class m170731_132022_update_catalog_sale_lang_table
 */
class m170731_132022_update_catalog_sale_lang_table extends Migration
{
    /**
     * table name
     * @var string
     */
    public $tableLang = '{{%sale_catalog_item_lang}}';

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
        $this->dropColumn($this->tableLang, 'full_title');

        $this->renameColumn($this->tableLang, 'language_code', 'lang');

        $this->renameColumn($this->tableLang, 'text', 'content');

        $this->alterColumn($this->tableLang, 'lang', $this->string(5)->notNull()->comment('Language'));

        // change lang 'ru' on 'ru-RU'
        $this->update($this->tableLang, ['lang' => 'ru-RU'], ['lang' => 'ru']);

        $this->renameTable('sale_catalog_item_lang', 'catalog_sale_item_lang');
    }

    /**
     * Cancel migration
     */
    public function safeDown()
    {
        $this->renameTable('catalog_sale_item_lang', 'sale_catalog_item_lang');

        $this->renameColumn($this->tableLang, 'content', 'text');

        $this->renameColumn($this->tableLang, 'lang', 'language_code');

        $this->addColumn($this->tableLang, 'full_title', $this->string(255)->defaultValue(null)->after('title'));
    }
}
