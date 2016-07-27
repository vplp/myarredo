<?php

use yii\db\Migration;
use thread\modules\user\User;

/**
 * Class m160127_022121_create_fv_auth_item_child_table
 *
 * @package thread\modules\user
 * @author FilamentV <vortex.filament@gmail.com>
 * @author Roman Gonchar <roman.gonchar92@gmail.com>
 * @copyright (c) 2016, VipDesign
 */
class m160127_022121_create_fv_auth_item_child_table extends Migration
{
    /**
     * Auth item table name
     * @var string
     */
    public $tableAuthItem = '{{%auth_item}}';

    /**
     * Auth item child table name
     * @var string
     */
    public $tableAuthItemChild = '{{%auth_item_child}}';

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
        /** Create table */
        $this->createTable($this->tableAuthItemChild, [
            'parent' => $this->string(64)->notNull(),
            'child' => $this->string(64)->notNull()
        ]);

        /** Add index and PK */
        $this->addPrimaryKey('pk', $this->tableAuthItemChild, ['parent', 'child']);
        $this->createIndex('child', $this->tableAuthItemChild, 'child');

        /** Create FKs */
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

    /**
     * Cancel migration
     */
    public function safeDown()
    {
        /** Remove FKs asn indexes */
        $this->dropForeignKey('fk-auth_item_child-child-auth_item-name', $this->tableAuthItemChild);
        $this->dropForeignKey('fk-auth_item_child-parent-auth_item-name', $this->tableAuthItemChild);
        $this->dropIndex('child', $this->tableAuthItemChild);
        $this->dropPrimaryKey('pk', $this->tableAuthItemChild);
        /** Drop table */
        $this->dropTable($this->tableAuthItemChild);
    }
}
