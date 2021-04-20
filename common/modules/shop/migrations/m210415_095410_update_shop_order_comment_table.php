<?php

use yii\db\Migration;
use common\modules\shop\Shop as ParentModule;

class m210415_095410_update_shop_order_comment_table extends Migration
{
    /**
     * @var string
     */
    public $table = '{{%shop_order_comment}}';

    /**
     *
     */
    public function init()
    {
        $this->db = ParentModule::getDb();
        parent::init();
    }

    /**
     * @return bool|void
     */
    public function safeUp()
    {
        $this->renameColumn($this->table, 'comment', 'content');

        $this->addColumn($this->table, 'type', "enum('comment','reminder') NOT NULL DEFAULT 'comment' after user_id");
        $this->createIndex('type', $this->table, 'type');

        $this->addColumn($this->table, 'reminder_time', $this->integer(10)->notNull()->defaultValue(0)->after('content'));
        $this->createIndex('reminder_time', $this->table, 'reminder_time');
    }

    /**
     * @return bool|void
     */
    public function safeDown()
    {
        $this->dropIndex('reminder_time', $this->table);
        $this->dropColumn($this->table, 'reminder_time');

        $this->dropIndex('type', $this->table);
        $this->dropColumn($this->table, 'type');

        $this->renameColumn($this->table, 'content', 'comment');
    }
}
