<?php

use yii\db\Migration;

/**
 * Class m160607_130950_insert_auth_item
 *
 * @package thread\modules\user
 * @author Roman Gonchar <roman.gonchar92@gmail.com>
 * @copyright (c) 2016, VipDesign
 */
class m160607_130950_insert_auth_item extends Migration
{

    /**
     * Auth item table name
     * @var string
     */
    public $tableAuthItem = '{{%auth_item}}';

    /**
     * Auth assignment table name
     * @var string
     */
    public $tableAuthAssignment = '{{%auth_assignment}}';

    /**
     * Auth item child table name
     * @var string
     */
    public $tableAuthItemChild = '{{%auth_item_child}}';

    /**
     * Implement migration
     */
    public function safeUp()
    {
        $this->batchInsert(
            $this->tableAuthItem,
            [
                'name',
                'type',
                'description',
                'rule_name',
                'data',
                'created_at',
                'updated_at',
            ],
            [
                [
                    'name' => 'dev',
                    'type' => 1,
                    'description' => 'developer',
                    'rule_name' => null,
                    'data' => null,
                    'created_at' => time(),
                    'updated_at' => time(),
                ],
                [
                    'name' => 'admin',
                    'type' => 1,
                    'description' => 'admin',
                    'rule_name' => null,
                    'data' => null,
                    'created_at' => time(),
                    'updated_at' => time(),
                ],
                [
                    'name' => 'user',
                    'type' => 1,
                    'description' => 'user',
                    'rule_name' => null,
                    'data' => null,
                    'created_at' => time(),
                    'updated_at' => time(),
                ]
            ]
        );
    }

    /**
     * Cancel migration
     */
    public function safeDown()
    {
        /** Drop related FKs */
        $this->dropForeignKey('fk-auth_assignment-item_name-auth_item-name', $this->tableAuthAssignment);
        $this->dropForeignKey('fk-auth_item_child-child-auth_item-name', $this->tableAuthItemChild);
        $this->dropForeignKey('fk-auth_item_child-parent-auth_item-name', $this->tableAuthItemChild);

        /** Empty table */
        $this->truncateTable($this->tableAuthItem);

        /** Recreate deleted FKs */
        $this->addForeignKey(
            'fk-auth_assignment-item_name-auth_item-name',
            $this->tableAuthAssignment,
            'item_name',
            $this->tableAuthItem,
            'name',
            'CASCADE',
            'CASCADE'
        );
        $this->addForeignKey(
            'fk-auth_item_child-parent-auth_item-name',
            $this->tableAuthItemChild,
            'parent',
            $this->tableAuthItem,
            'name',
            'CASCADE',
            'CASCADE'
        );
        $this->addForeignKey(
            'fk-auth_item_child-child-auth_item-name',
            $this->tableAuthItemChild,
            'child',
            $this->tableAuthItem,
            'name',
            'CASCADE',
            'CASCADE'
        );
    }
}
