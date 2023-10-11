<?php

use yii\db\Migration;
use common\modules\shop\Shop;

class m171129_154403_update_shop_cart_table extends Migration
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
        $this->db = Shop::getDb();
        parent::init();
    }

    /**
     * Implement migration
     */
    public function safeUp()
    {
        $this->alterColumn($this->table, 'php_session_id', $this->string(180)->notNull()->comment('Session ID'));
    }

    /**
     * Cancel migration
     */
    public function safeDown()
    {
        $this->alterColumn($this->table, 'php_session_id', $this->string(30)->notNull()->comment('Session ID'));
    }
}
