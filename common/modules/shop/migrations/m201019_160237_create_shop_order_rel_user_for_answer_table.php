<?php

use yii\db\Migration;
use common\modules\shop\Shop as ParentModule;

/**
 * Handles the creation of table `{{%shop_order_rel_user_for_answer}}`.
 */
class m201019_160237_create_shop_order_rel_user_for_answer_table extends Migration
{
    /**
     * @var string
     */
    public $tableRel = '{{%shop_order_rel_user_for_answer}}';

    /**
     * @var string
     */
    public $tableOrder = '{{%shop_order}}';

    /**
     * @var string
     */
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
        $this->createTable($this->tableRel, [
            'order_id' => $this->integer(11)->unsigned()->notNull(),
            'user_id' => $this->integer(11)->unsigned()->notNull(),
        ]);

        $this->createIndex('order_id', $this->tableRel, 'order_id');
        $this->createIndex('user_id', $this->tableRel, 'user_id');
        $this->createIndex('order_id_user_id', $this->tableRel, ['order_id', 'user_id'], true);

        $this->addForeignKey(
            'fk-shop_order_rel_user_for_answer_ibfk_1',
            $this->tableRel,
            'order_id',
            $this->tableOrder,
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-shop_order_rel_user_for_answer_ibfk_2',
            $this->tableRel,
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
        $this->dropForeignKey('fk-shop_order_rel_user_for_answer_ibfk_2', $this->tableRel);
        $this->dropForeignKey('fk-shop_order_rel_user_for_answer_ibfk_1', $this->tableRel);

        $this->dropIndex('order_id_user_id', $this->tableRel);
        $this->dropIndex('user_id', $this->tableRel);
        $this->dropIndex('order_id', $this->tableRel);

        $this->dropTable($this->tableRel);
    }
}
