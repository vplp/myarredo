<?php

use yii\db\Migration;
use common\modules\shop\modules\market\Market as ParentModule;

/**
 * Handles the creation of table `{{%shop_market_order}}`.
 */
class m210426_150950_create_shop_market_order_table extends Migration
{
    /**
     * @var string
     */
    public $table = '{{%shop_market_order}}';

    /**
     *
     */
    public function init()
    {
        $this->db = ParentModule::getDb();
        parent::init();
    }

    /**
     * @return bool|void
     */
    public function safeUp()
    {
        $this->createTable($this->table, [
            'id' => $this->primaryKey()->unsigned()->comment('ID'),
            'winner_id' => $this->integer(11)->unsigned()->notNull(),
            'email' => $this->string(255)->notNull()->comment('Email'),
            'full_name' => $this->string(255)->notNull(),
            'country_id' => $this->integer(11)->unsigned()->notNull(),
            'city_id' => $this->integer(11)->unsigned()->notNull(),
            'comment' =>  $this->string(512)->notNull()->defaultValue(''),
            'cost' => "decimal(10,2) NOT NULL DEFAULT '0.00'",
            'currency' => "enum('EUR','RUB','USD') NOT NULL DEFAULT 'EUR'",
            'created_at' => $this->integer()->unsigned()->notNull()->defaultValue(0),
            'updated_at' => $this->integer()->unsigned()->notNull()->defaultValue(0),
            'published' => "enum('0','1') NOT NULL DEFAULT '1'",
            'deleted' => "enum('0','1') NOT NULL DEFAULT '0'"
        ]);

        $this->createIndex('winner_id', $this->table, 'winner_id');
        $this->createIndex('country_id', $this->table, 'country_id');
        $this->createIndex('city_id', $this->table, 'city_id');
        $this->createIndex('published', $this->table, 'published');
        $this->createIndex('deleted', $this->table, 'deleted');
    }

    /**
     * @return bool|void
     */
    public function safeDown()
    {
        $this->dropIndex('deleted', $this->table);
        $this->dropIndex('published', $this->table);
        $this->dropIndex('city_id', $this->table);
        $this->dropIndex('country_id', $this->table);
        $this->dropIndex('winner_id', $this->table);

        $this->dropTable($this->table);
    }
}
