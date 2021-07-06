<?php

use yii\db\Migration;
use common\modules\catalog\Catalog as ParentModule;

class m210706_145538_update_seo_direct_link_table extends Migration
{
    /**
     * table name
     * @var string
     */
    public $table = '{{%seo_direct_link}}';

    /**
     * @inheritdoc
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
