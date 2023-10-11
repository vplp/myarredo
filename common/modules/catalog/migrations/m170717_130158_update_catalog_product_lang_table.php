<?php

use yii\db\Migration;
//
use common\modules\catalog\Catalog;

/**
 * Class m170717_130158_update_catalog_product_lang_table
 */
class m170717_130158_update_catalog_product_lang_table extends Migration
{
    /**
     * table lang name
     * @var string
     */
    public $tableLang = '{{%catalog_item_lang}}';

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
        $this->renameColumn($this->tableLang, 'text', 'content');

        $this->alterColumn($this->tableLang, 'lang', $this->string(5)->notNull()->comment('Language'));

        // change lang 'ru' on 'ru-RU'
        $this->update($this->tableLang, ['lang' => 'ru-RU'], ['lang' => 'ru']);
    }

    /**
     * Cancel migration
     */
    public function safeDown()
    {
        $this->renameColumn($this->tableLang, 'content', 'text');
        $this->renameColumn($this->tableLang, 'lang', 'language_code');
    }
}
