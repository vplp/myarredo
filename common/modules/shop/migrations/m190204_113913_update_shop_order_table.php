<?php

use yii\db\Migration;
use common\modules\shop\Shop;

class m190204_113913_update_shop_order_table extends Migration
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
        $this->db = Shop::getDb();
        parent::init();
    }

    /**
     * Implement migration
     */
    public function safeUp()
    {
        $this->addColumn(
            $this->table,
            'lang',
            $this->string(5)->notNull()->defaultValue('ru-RU')->comment('Language')->after('id')
        );
    }

    /**
     * Cancel migration
     */
    public function safeDown()
    {
        $this->dropColumn($this->table, 'lang');
    }
}
