<?php

use yii\db\Migration;
use thread\modules\user\User;

/**
 * Class m160127_022122_create_fv_auth_assignment_table
 *
 * @package thread\modules\user
 * @author FilamentV <vortex.filament@gmail.com>
 * @author Roman Gonchar <roman.gonchar92@gmail.com>
 * @copyright (c) 2016, VipDesign
 */
class m160127_022122_create_fv_auth_assignment_table extends Migration
{
    /**
     * Auth assignment table name
     * @var string
     */
    public $tableAuthAssignment = '{{%auth_assignment}}';

    /**
     * auth item table name
     * @var string
     */
    public $tableAuthItem = '{{%auth_item}}';

    /**
     * Core DB connection
     */
    public function init()
    {
        $this->db = User::getDb();
        parent::init();
    }

    /**
     * Implement migration
     */
    public function safeUp()
    {
        $this->createTable($this->tableAuthAssignment, [
            'item_name' => $this->string(64)->notNull(),
            'user_id' => $this->string(64)->notNull(),
            'created_at' => $this->integer(11)->defaultValue(null),
        ]);
        
        $this->addPrimaryKey('pk', $this->tableAuthAssignment, ['item_name', 'user_id']);

        $this->addForeignKey(
            'fk-auth_assignment-item_name-auth_item-name',
            $this->tableAuthAssignment,
            'item_name',
            $this->tableAuthItem,
            'name',
            'CASCADE',
            'CASCADE'
        );
    }

    /**
     * Cancel migration
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-auth_assignment-item_name-auth_item-name', $this->tableAuthAssignment);
        $this->dropPrimaryKey('pk', $this->tableAuthAssignment);
        $this->dropTable($this->tableAuthAssignment);
    }
}
