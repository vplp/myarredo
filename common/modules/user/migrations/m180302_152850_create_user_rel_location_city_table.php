<?php

use yii\db\Migration;
//
use common\modules\user\User as UserModule;

/**
 * Handles the creation of table `user_rel_location_city`.
 */
class m180302_152850_create_user_rel_location_city_table extends Migration
{
    /**
     * table name
     * @var string
     */
    public $table= '{{%user_rel_location_city}}';

    /**
     * @var string
     */
    public $tableSeoDirectLink = '{{%user}}';

    /**
     * @var string
     */
    public $tableLocationCity = '{{%location_city}}';
    
    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->db = UserModule::getDb();
        parent::init();
    }

    /**
     * Implement migration
     */
    public function safeUp()
    {
        $this->createTable($this->table, [
            'user_id' => $this->integer(11)->unsigned()->notNull(),
            'location_city_id' => $this->integer(11)->unsigned()->notNull()
        ]);

        $this->createIndex('user_id', $this->table, 'user_id');
        $this->createIndex('location_city_id', $this->table, 'location_city_id');
        $this->createIndex('user_id_location_city_id', $this->table, ['user_id', 'location_city_id'], true);

        $this->addForeignKey(
            'fk-user_rel_location_city_ibfk_1',
            $this->table,
            'location_city_id',
            $this->tableLocationCity,
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-user_rel_location_city_ibfk_2',
            $this->table,
            'user_id',
            $this->tableSeoDirectLink,
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
        $this->dropForeignKey('fk-user_rel_location_city_ibfk_1', $this->table);
        $this->dropForeignKey('fk-user_rel_location_city_ibfk_2', $this->table);

        $this->dropIndex('user_id_location_city_id', $this->table);

        $this->dropIndex('user_id', $this->table);
        $this->dropIndex('location_city_id', $this->table);

        $this->dropTable($this->table);
    }
}
