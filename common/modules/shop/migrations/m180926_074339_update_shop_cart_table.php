<?php

use yii\db\Migration;
use common\modules\shop\Shop as ShopModule;

class m180926_074339_update_shop_cart_table extends Migration
{
    /**
     * table name
     * @var string
     */
    public $table = '{{%shop_cart}}';

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
        $this->createIndex('php_session_id', $this->table, 'php_session_id', true);
    }

    /**
     * Cancel migration
     */
    public function safeDown()
    {
        $this->dropIndex('php_session_id', $this->table);
    }
}
