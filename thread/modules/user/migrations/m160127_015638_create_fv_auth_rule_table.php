<?php

use yii\db\Migration;
use thread\modules\user\User;

/**
 * Class m160127_015638_create_fv_auth_rule_table
 *
 * @package thread\modules\user
 * @author FilamentV <vortex.filament@gmail.com>
 * @author Roman Gonchar <roman.gonchar92@gmail.com>
 * @copyright (c) 2016, VipDesign
 */
class m160127_015638_create_fv_auth_rule_table extends Migration
{
    /**
     * Table name
     * @var string
     */
    public $tableAuthRule = '{{%auth_rule}}';

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
        $this->createTable($this->tableAuthRule, [
            'name' => $this->string(64)->notNull(),
            'data' => $this->text(),
            'created_at' => $this->integer(11)->defaultValue(null),
            'updated_at' => $this->integer(11)->defaultValue(null)
        ]);
        
        /** Add PK */
        $this->addPrimaryKey('pk', $this->tableAuthRule, 'name');
    }

    /**
     * Cancel migration
     */
    public function safeDown()
    {
        $this->dropPrimaryKey('pk', $this->tableAuthRule);
        $this->dropTable($this->tableAuthRule);
    }
}
