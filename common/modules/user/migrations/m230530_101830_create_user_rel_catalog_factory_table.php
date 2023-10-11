<?php

use yii\db\Migration;
use common\modules\user\User as UserModule;

/**
 * Handles the creation of table `{{%user_rel_catalog_factory}}`.
 */
class m230530_101830_create_user_rel_catalog_factory_table extends Migration
{
    /**
     * table name
     * @var string
     */
    public $table = '{{%user_rel_catalog_factory}}';

    /**
     * @var string
     */
    public $tableUser = '{{%user}}';

    /**
     * @var string
     */
    public $tableCatalogFactory = '{{%catalog_factory}}';

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
            'catalog_factory_id' => $this->integer(11)->unsigned()->notNull()
        ]);

        $this->createIndex('user_id', $this->table, 'user_id');
        $this->createIndex('catalog_factory_id', $this->table, 'catalog_factory_id');
        $this->createIndex('user_id_catalog_factory_id', $this->table, ['user_id', 'catalog_factory_id'], true);

        $this->addForeignKey(
            'fk-user_rel_catalog_factory_ibfk_1',
            $this->table,
            'catalog_factory_id',
            $this->tableCatalogFactory,
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-user_rel_catalog_factory_ibfk_2',
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
        /*$users = (new \yii\db\Query())
            ->from($this->tableUser)
            ->where(['group_id' => 3])
            ->all();

        $factories = (new \yii\db\Query())
            ->from($this->tableCatalogFactory)
            ->all();

        foreach ($users as $user) {
            foreach ($factories as $factory) {
                Yii::$app->db->createCommand()
                    ->insert(
                        $this->table,
                        [
                            'user_id' => $user['id'],
                            'catalog_factory_id' => $factory['id']
                        ]
                    )
                    ->execute();
            }
        }*/
    }

    /**
     * Cancel migration
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-user_rel_catalog_factory_ibfk_1', $this->table);
        $this->dropForeignKey('fk-user_rel_catalog_factory_ibfk_2', $this->table);

        $this->dropIndex('user_id_catalog_factory_id', $this->table);

        $this->dropIndex('user_id', $this->table);
        $this->dropIndex('catalog_factory_id', $this->table);

        $this->dropTable($this->table);
    }
}
