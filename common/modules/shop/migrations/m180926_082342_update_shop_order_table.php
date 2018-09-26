<?php

use yii\db\Migration;
use common\modules\shop\Shop as ShopModule;

class m180926_082342_update_shop_order_table extends Migration
{
    /**
     * table name
     * @var string
     */
    public $table = '{{%shop_order}}';

    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->db = ShopModule::getDb();
        parent::init();
    }

    /**
     * Implement migration
     */
    public function safeUp()
    {
        $this->createIndex('city_id', $this->table, 'city_id');
        $this->createIndex('create_campaign', $this->table, 'create_campaign');

        $this->dropColumn($this->table, 'manager_id');
    }

    /**
     * Cancel migration
     */
    public function safeDown()
    {
        $this->addColumn(
            $this->table,
            'manager_id',
            $this->integer(11)->unsigned()->notNull()->defaultValue(0)->comment('Manager ID')
        );

        $this->dropIndex('create_campaign', $this->table);
        $this->dropIndex('city_id', $this->table);
    }
}
