<?php

use yii\db\Migration;
use common\modules\shop\Shop as ParentModule;

class m201204_142341_update_shop_order_table extends Migration
{
    /**
     * table name
     * @var string
     */
    public $table = '{{%shop_order}}';

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
        $this->addColumn($this->table, 'order_first_url_visit', $this->text()->defaultValue(null)->after('comment'));
        $this->addColumn($this->table, 'order_count_url_visit', $this->integer()->unsigned()->notNull()->defaultValue(0)->after('order_first_url_visit'));
    }

    /**
     * Cancel migration
     */
    public function safeDown()
    {
        $this->dropColumn($this->table, 'order_count_url_visit');
        $this->dropColumn($this->table, 'order_first_url_visit');
    }
}
