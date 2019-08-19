<?php

use yii\db\Migration;
//
use common\modules\banner\BannerModule;

class m190819_104658_update_banner_item_table extends Migration
{
    /**
     * table name
     * @var string
     */
    public $table = '{{%banner_item}}';

    /**
     *
     */
    public function init()
    {
        $this->db = BannerModule::getDb();
        parent::init();
    }

    /**
     * Implement migration
     */
    public function safeUp()
    {
        $this->addColumn(
            $this->table,
            'type',
            "enum('main','catalog','factory') NOT NULL DEFAULT 'factory' COMMENT 'Type' AFTER factory_id"
        );

        $this->createIndex('type', $this->table, 'type');
    }

    /**
     * Cancel migration
     */
    public function safeDown()
    {
        $this->dropIndex('type', $this->table);

        $this->dropColumn($this->table, 'type');
    }
}
