<?php

use yii\db\Migration;
use thread\modules\user\User;

/**
 * Class m160127_022108_create_fv_auth_item_table
 *
 * @package thread\modules\user
 * @author FilamentV <vortex.filament@gmail.com>
 * @author Roman Gonchar <roman.gonchar92@gmail.com>
 * @copyright (c) 2016, VipDesign
 */
class m160127_022108_create_fv_auth_item_table extends Migration
{
    /**
     * Auth item table name
     * @var string
     */
    public $tableAuthItem = '{{%auth_item}}';

    /**
     * Auth rule table name
     * @var string
     */
    public $tableAuthRule = '{{%auth_rule}}';

    /**
     * Core DB connction
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
        $this->createTable($this->tableAuthItem, [
            'name' => $this->string(64)->notNull(),
            'type' => $this->integer(11)->notNull(),
            'description' => $this->text(),
            'rule_name' => $this->string(64)->defaultValue(null),
            'data' => $this->text(),
            'created_at' => $this->integer(11)->defaultValue(null),
            'updated_at' => $this->integer(11)->defaultValue(null)
        ]);

        /** Add PK */
        $this->addPrimaryKey('name', $this->tableAuthItem, 'name');

        /** Add indexes */
        $this->createIndex('rule_name', $this->tableAuthItem, 'rule_name');
        $this->createIndex('idx-auth_item-type', $this->tableAuthItem, 'type');

        /** Create FK to auth rules table */
        $this->addForeignKey(
            'fk-auth_item-rule_name-auth_rule-name',
            $this->tableAuthItem,
            'rule_name',
            $this->tableAuthRule,
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
        $this->dropForeignKey('fk-auth_item-rule_name-auth_rule-name', $this->tableAuthItem);
        $this->dropIndex('idx-auth_item-type', $this->tableAuthItem);
        $this->dropIndex('rule_name', $this->tableAuthItem);
        $this->dropPrimaryKey('name', $this->tableAuthItem);
        $this->dropTable($this->tableAuthItem);
    }
}
