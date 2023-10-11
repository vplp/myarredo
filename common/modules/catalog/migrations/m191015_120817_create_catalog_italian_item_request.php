<?php

use yii\db\Migration;
//
use common\modules\catalog\Catalog;

class m191015_120817_create_catalog_italian_item_request extends Migration
{
    /**
     * table name
     * @var string
     */
    public $table = '{{%catalog_italian_item_request}}';

    /**
     * table name
     * @var string
     */
    public $tableSale = '{{%catalog_italian_item}}';

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
            'item_id' => $this->integer(11)->unsigned()->notNull()->defaultValue(0),
            'country_id' => $this->integer(11)->unsigned()->notNull()->defaultValue(0),
            'city_id' => $this->integer(11)->unsigned()->notNull()->defaultValue(0),
            'offer_price' => $this->float()->defaultValue(0),
            'email' => $this->string(255)->notNull()->comment('email'),
            'user_name' => $this->string(255)->notNull()->comment('user_name'),
            'phone' => $this->string(255)->notNull()->comment('phone'),
            'question' => $this->string(1025)->notNull()->comment('question'),
            'ip' => $this->string(45)->notNull(),
            'created_at' => $this->integer(11)->unsigned()->notNull()->defaultValue(0),
            'updated_at' => $this->integer(11)->unsigned()->notNull()->defaultValue(0),
        ]);

        $this->createIndex('idx-user_id', $this->table, 'user_id');
        $this->createIndex('idx-item_id', $this->table, 'item_id');
        $this->createIndex('idx-country_id', $this->table, 'country_id');
        $this->createIndex('idx-city_id', $this->table, 'city_id');
        $this->createIndex('idx-updated_at', $this->table, 'updated_at');

        $this->addForeignKey(
            'fk-catalog_italian_item_request_rel_catalog_italian_item_id_fk1',
            $this->table,
            'item_id',
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
        $this->dropForeignKey('fk-catalog_italian_item_request_rel_catalog_italian_item_id_fk1', $this->table);

        $this->dropIndex('idx-user_id', $this->table);
        $this->dropIndex('idx-item_id', $this->table);
        $this->dropIndex('idx-country_id', $this->table);
        $this->dropIndex('idx-city_id', $this->table);
        $this->dropIndex('idx-updated_at', $this->table);

        $this->dropTable($this->table);
    }
}
