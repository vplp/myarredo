<?php

use yii\db\Migration;
//
use common\modules\catalog\Catalog;

class m180514_140249_create_catalog_sale_request extends Migration
{
    /**
     * table name
     * @var string
     */
    public $table = '{{%catalog_sale_item_request}}';

    /**
     * table name
     * @var string
     */
    public $tableSale = '{{%catalog_sale_item}}';

    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->db = Catalog::getDb();
        parent::init();
    }

    /**
     * Implement migration
     */
    public function safeUp()
    {
        $this->createTable($this->table, [
            'id' => $this->primaryKey()->unsigned(),
            'user_id' => $this->integer(11)->unsigned()->notNull()->defaultValue(0),
            'sale_item_id' => $this->integer(11)->unsigned()->notNull()->defaultValue(0),
            'country_id' => $this->integer(11)->unsigned()->notNull()->defaultValue(0),
            'city_id' => $this->integer(11)->unsigned()->notNull()->defaultValue(0),
            'email' => $this->string(255)->notNull()->comment('email'),
            'user_name' => $this->string(255)->notNull()->comment('user_name'),
            'phone' => $this->string(255)->notNull()->comment('phone'),
            'question' => $this->string(1025)->notNull()->comment('question'),
            'ip' => $this->string(45)->notNull(),
            'created_at' => $this->integer(11)->unsigned()->notNull()->defaultValue(0),
            'updated_at' => $this->integer(11)->unsigned()->notNull()->defaultValue(0),
        ]);

        $this->createIndex('idx-user_id', $this->table, 'user_id');
        $this->createIndex('idx-sale_item_id', $this->table, 'sale_item_id');
        $this->createIndex('idx-country_id', $this->table, 'country_id');
        $this->createIndex('idx-city_id', $this->table, 'city_id');

        $this->addForeignKey(
            'fk-catalog_sale_item_request_rel_sale_item_id_fk1',
            $this->table,
            'sale_item_id',
            $this->tableSale,
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
        $this->dropForeignKey('fk-catalog_sale_item_request_rel_sale_item_id_fk1', $this->table);

        $this->dropIndex('idx-user_id', $this->table);
        $this->dropIndex('idx-sale_item_id', $this->table);
        $this->dropIndex('idx-country_id', $this->table);
        $this->dropIndex('idx-city_id', $this->table);

        $this->dropTable($this->table);
    }
}
