<?php

use yii\db\Migration;
//
use common\modules\catalog\Catalog;

class m180131_104824_update_catalog_sale_lang_table extends Migration
{
    /**
     * table name
     * @var string
     */
    public $tableLang = '{{%catalog_sale_item_lang}}';

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
        $this->alterColumn($this->tableLang, 'description', $this->text()->defaultValue(null)->comment('Description'));
    }

    /**
     * Cancel migration
     */
    public function safeDown()
    {
        $this->alterColumn($this->tableLang, 'description', $this->string(255)->defaultValue(null)->comment('Description'));
    }
}
