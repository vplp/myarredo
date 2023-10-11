<?php

use yii\db\Migration;
//
use common\modules\catalog\Catalog;

class m190815_114003_update_catalog_italian_item_table extends Migration
{
    /**
     * table name
     * @var string
     */
    public $table = '{{%catalog_italian_item}}';

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
        $this->alterColumn($this->table, 'status', "enum('not_considered','not_approved','on_moderation','approved') NOT NULL DEFAULT 'not_considered'");
    }

    /**
     * Cancel migration
     */
    public function safeDown()
    {
        $this->alterColumn($this->table, 'status', "enum('not_considered','not_approved','approved') NOT NULL DEFAULT 'not_considered'");
    }
}
