<?php

use yii\db\Migration;
use common\modules\shop\modules\market\Market as ParentModule;

/**
 * Handles the creation of table `{{%shop_market_order_answer}}`.
 */
class m210428_135449_create_shop_market_order_answer_table extends Migration
{
    /**
     * @var string
     */
    public $table = '{{%shop_market_order_answer}}';
    public $tableOrder = '{{%shop_market_order}}';
    public $tableUser = '{{%user}}';

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
        $this->createTable($this->table, [
            'id' => $this->primaryKey()->unsigned()->comment('ID'),
            'order_id' => $this->integer(11)->unsigned()->notNull(),
            'user_id' => $this->integer(11)->unsigned()->notNull(),
            'commission_percentage' => "decimal(10,2) NOT NULL DEFAULT '0.00'",
            'created_at' => $this->integer()->unsigned()->notNull()->defaultValue(0)->comment('Create time'),
            'updated_at' => $this->integer()->unsigned()->notNull()->defaultValue(0)->comment('Update time'),
        ]);

        $this->createIndex('order_id', $this->table, 'order_id');
        $this->createIndex('user_id', $this->table, 'user_id');

        $this->addForeignKey(
            'fk-shop_market_order_answer_ibfk_1',
            $this->table,
            'order_id',
            $this->tableOrder,
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-shop_market_order_answer_ibfk_2',
            $this->table,
            'user_id',
            $this->tableUser,
            'id',
            'CASCADE',
            'CASCADE'
        );
    }

    /**
     * Cancel migration
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-shop_market_order_answer_ibfk_2', $this->table);
        $this->dropForeignKey('fk-shop_market_order_answer_ibfk_1', $this->table);

        $this->dropTable($this->table);
    }
}
