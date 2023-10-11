<?php

use yii\db\Migration;
use common\modules\user\User as UserModule;

/**
 * Handles the creation of table `{{%user_rel_location_country}}`.
 */
class m200602_101146_create_user_rel_location_country_table extends Migration
{
    /**
     * table name
     * @var string
     */
    public $table = '{{%user_rel_location_country}}';

    /**
     * @var string
     */
    public $tableUser = '{{%user}}';

    /**
     * @var string
     */
    public $tableLocationCountry = '{{%location_country}}';

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
            'location_country_id' => $this->integer(11)->unsigned()->notNull()
        ]);

        $this->createIndex('user_id', $this->table, 'user_id');
        $this->createIndex('location_country_id', $this->table, 'location_country_id');
        $this->createIndex('user_id_location_country_id', $this->table, ['user_id', 'location_country_id'], true);

        $this->addForeignKey(
            'fk-user_rel_location_country_ibfk_1',
            $this->table,
            'location_country_id',
            $this->tableLocationCountry,
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-user_rel_location_country_ibfk_2',
            $this->table,
            'user_id',
            $this->tableUser,
            'id',
            'CASCADE',
            'CASCADE'
        );

        /**
         * Update table
         */
        $users = (new \yii\db\Query())
            ->from($this->tableUser)
            ->where(['group_id' => 3])
            ->all();

        $countries = (new \yii\db\Query())
            ->from($this->tableLocationCountry)
            ->all();

        foreach ($users as $user) {
            foreach ($countries as $country) {
                Yii::$app->db->createCommand()
                    ->insert(
                        $this->table,
                        [
                            'user_id' => $user['id'],
                            'location_country_id' => $country['id']
                        ]
                    )
                    ->execute();
            }
        }
    }

    /**
     * Cancel migration
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-user_rel_location_country_ibfk_1', $this->table);
        $this->dropForeignKey('fk-user_rel_location_country_ibfk_2', $this->table);

        $this->dropIndex('user_id_location_country_id', $this->table);

        $this->dropIndex('user_id', $this->table);
        $this->dropIndex('location_country_id', $this->table);

        $this->dropTable($this->table);
    }
}
