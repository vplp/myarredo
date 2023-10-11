<?php

use yii\db\Migration;
use common\modules\shop\Shop;

/**
 * Class m171129_093625_update_shop_order_answer_table
 */
class m171129_093625_update_shop_order_answer_table extends Migration
{
    /**
     * table name
     * @var string
     */
    public $table = '{{%shop_order_answer}}';

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
        $this->addColumn($this->table, 'answer_time', $this->integer(11)->notNull()->defaultValue(0)->after('answer'));
        $this->addColumn($this->table, 'results', $this->string(255)->defaultValue(null)->after('answer_time'));
    }

    /**
     * Cancel migration
     */
    public function safeDown()
    {
        $this->dropColumn($this->table, 'answer_time');
        $this->dropColumn($this->table, 'results');
    }
}
