<?php

use yii\db\Migration;
use common\modules\shop\Shop;

/**
 * Class m170929_110148_create_table_shop_order_answer
 */
class m170929_110148_create_table_shop_order_answer extends Migration
{
    /**
     * @var string
     */
    public $tableOrderAnswer = '{{%shop_order_answer}}';
    public $tableOrder = '{{%shop_order}}';
    public $tableUser = '{{%user}}';

    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->db = Shop::getDb();
        parent::init();
    }

    /**
     * Implement migration
     */
    public function safeUp()
    {
        $this->createTable($this->tableOrderAnswer, [
            'id' => $this->primaryKey()->unsigned()->comment('ID'),
            'order_id' => $this->integer(11)->unsigned()->notNull()->comment('Related model ID with shop_order'),
            'user_id' => $this->integer(11)->unsigned()->notNull()->comment('Related model ID with user'),
            'answer' =>  $this->text()->defaultValue(null)->comment('answer'),
            'created_at' => $this->integer()->unsigned()->notNull()->defaultValue(0)->comment('Create time'),
            'updated_at' => $this->integer()->unsigned()->notNull()->defaultValue(0)->comment('Update time'),
            'published' => "enum('0','1') NOT NULL DEFAULT '1' COMMENT 'Published'",
            'deleted' => "enum('0','1') NOT NULL DEFAULT '0' COMMENT 'Deleted'",

        ]);

        $this->createIndex('published', $this->tableOrderAnswer, 'published');
        $this->createIndex('deleted', $this->tableOrderAnswer, 'deleted');

        $this->addForeignKey(
            'fk-shop_order_answer-order_id-shop_order-id',
            $this->tableOrderAnswer,
            'order_id',
            $this->tableOrder,
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-shop_order_answer-user_id-user-id',
            $this->tableOrderAnswer,
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
        $this->dropForeignKey('fk-shop_order_answer-user_id-user-id', $this->tableOrderAnswer);
        $this->dropForeignKey('fk-shop_order_answer-order_id-shop_order-id', $this->tableOrderAnswer);

        $this->dropIndex('deleted', $this->tableOrderAnswer);
        $this->dropIndex('published', $this->tableOrderAnswer);

        $this->dropTable($this->tableOrderAnswer);
    }
}
