<?php

use yii\db\Migration;
//
use common\modules\banner\BannerModule;

class m191213_150604_update_banner_item_table extends Migration
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
        $this->alterColumn(
            $this->table,
            'type',
            "enum('main','catalog','factory', 'background') NOT NULL DEFAULT 'factory' COMMENT 'Type' AFTER factory_id"
        );

        $this->addColumn(
            $this->table,
            'side',
            "enum('left','right') NOT NULL DEFAULT 'left' COMMENT 'Side' AFTER type"
        );

        $this->createIndex('side', $this->table, 'side');
    }

    /**
     * Cancel migration
     */
    public function safeDown()
    {
        $this->alterColumn(
            $this->table,
            'type',
            "enum('main','catalog','factory') NOT NULL DEFAULT 'factory' COMMENT 'Type' AFTER factory_id"
        );

        $this->dropIndex('side', $this->table);

        $this->dropColumn($this->table, 'side');
    }
}
