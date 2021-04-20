<?php

use yii\db\Migration;
use common\modules\banner\BannerModule as ParentModule;

class m210405_124354_update_banner_item_table extends Migration
{

    /**
    * @var string
    */
    public $table = '{{%banner_item}}';

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
        $this->addColumn(
            $this->table,
            'show_filter',
            "enum('0','1') NOT NULL DEFAULT '0'"
        );

        $this->createIndex('show_filter', $this->table, 'show_filter');
    }

    /**
     * Cancel migration
     */
    public function safeDown()
    {
        $this->dropIndex('show_filter', $this->table);

        $this->dropColumn($this->table, 'show_filter');
    }
}
