<?php

use yii\db\Migration;
use common\modules\shop\Shop as ParentModule;

/**
 * Handles the creation of table `{{%shop_order_comment}}`.
 */
class m210413_124136_create_shop_order_comment_table extends Migration
{
    /**
     * @var string
     */
    public $table = '{{%shop_order_comment}}';
    public $tableOrder = '{{%shop_order}}';

    /**
     *
     */
    public function init()
    {
        $this->db = ParentModule::getDb();
        parent::init();
    }

    public function safeUp()
    {
        $this->createTable($this->table, [
            'id' => $this->primaryKey()->unsigned(),
            'order_id' => $this->integer(11)->unsigned()->notNull(),
            'user_id' => $this->integer(11)->unsigned()->notNull(),
            'comment' => $this->text()->defaultValue(null),
            'created_at' => $this->integer()->unsigned()->notNull()->defaultValue(0),
            'updated_at' => $this->integer()->unsigned()->notNull()->defaultValue(0),
            'published' => "enum('0','1') NOT NULL DEFAULT '1'",
            'deleted' => "enum('0','1') NOT NULL DEFAULT '0'"
        ]);

        $this->createIndex('published', $this->table, 'published');
        $this->createIndex('deleted', $this->table, 'deleted');

        $this->addForeignKey(
            'fk-shop_order_comment-order_id-shop_order-id',
            $this->table,
            'order_id',
            $this->tableOrder,
            'id',
            'CASCADE',
            'CASCADE'
        );
    }

    public function safeDown()
    {
        $this->dropForeignKey('fk-shop_order_comment-order_id-shop_order-id', $this->table);

        $this->dropIndex('deleted', $this->table);
        $this->dropIndex('published', $this->table);

        $this->dropTable($this->table);
    }
}
