<?php

use common\modules\catalog\Catalog as ParentModule;
use yii\db\Migration;

class m220124_161930_update_catalog_product_lang_table extends Migration
{

    /**
     * @var string
     */
    public $table = '{{%catalog_item_lang}}';

    /**
     *
     */
    public function init()
    {
        $this->db = ParentModule::getDb();
        parent::init();
    }

    /**
     * Implement migration
     */
    public function safeUp()
    {
        $this->addColumn($this->table, 'mark', "enum('0','1') NOT NULL DEFAULT '0' COMMENT 'Mark'");
        $this->createIndex('mark', $this->table, 'mark');
    }

    /**
     * Cancel migration
     */
    public function safeDown()
    {
        $this->dropIndex('mark', $this->table);
        $this->dropColumn($this->table, 'mark');
    }
}
