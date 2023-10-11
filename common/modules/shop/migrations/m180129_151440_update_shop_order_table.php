<?php

use yii\db\Migration;
use common\modules\shop\Shop;

class m180129_151440_update_shop_order_table extends Migration
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
        $this->addColumn($this->table, 'create_campaign',  "enum('0','1') NOT NULL DEFAULT '0' COMMENT 'Create campaign in SendPulse'");

        // UPDATE
        $connection = Yii::$app->db;

        $connection->createCommand()
            ->update($this->table, ['create_campaign' => '1'])
            ->execute();
    }

    /**
     * Cancel migration
     */
    public function safeDown()
    {
        $this->dropColumn($this->table, 'create_campaign');
    }
}
