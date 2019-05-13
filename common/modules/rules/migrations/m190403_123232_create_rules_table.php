<?php

use yii\db\Migration;
use common\modules\rules\RulesModule;

/**
 * Handles the creation of table `{{%rules}}`.
 */
class m190403_123232_create_rules_table extends Migration
{
    /**
     * @var string
     */
    public $table = '{{%rules}}';

    /**
     * @throws \yii\base\InvalidConfigException
     */
    public function init()
    {
        $this->db = RulesModule::getDb();
        parent::init();
    }

    /**
     * Implement migration
     */
    public function safeUp()
    {
        $this->createTable($this->table, [
            'id' => $this->primaryKey()->unsigned()->comment('ID'),
            'position' => $this->integer(11)->unsigned()->defaultValue(0),
            'created_at' => $this->integer()->unsigned()->notNull()->defaultValue(0),
            'updated_at' => $this->integer()->unsigned()->notNull()->defaultValue(0),
            'published' => "enum('0','1') NOT NULL DEFAULT '0'",
            'deleted' => "enum('0','1') NOT NULL DEFAULT '0'",
        ]);

        $this->createIndex('position', $this->table, 'position');
        $this->createIndex('published', $this->table, 'published');
        $this->createIndex('deleted', $this->table, 'deleted');
    }

    /**
     * Cancel migration
     */
    public function safeDown()
    {
        $this->dropIndex('deleted', $this->table);
        $this->dropIndex('published', $this->table);
        $this->dropIndex('position', $this->table);

        $this->dropTable($this->table);
    }
}
