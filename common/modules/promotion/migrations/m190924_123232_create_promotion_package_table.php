<?php

use yii\db\Migration;
use common\modules\rules\RulesModule;

/**
 * Handles the creation of table `{{%promotion_package}}`.
 */
class m190924_123232_create_promotion_package_table extends Migration
{
    /**
     * @var string
     */
    public $table = '{{%promotion_package}}';

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
            'image_link' => $this->string(255)->defaultValue(null),
            'price' => $this->float()->defaultValue(0.00),
            'currency' => "enum('EUR','RUB') NOT NULL DEFAULT 'EUR'",
            'position' => $this->integer(11)->unsigned()->defaultValue(0),
            'created_at' => $this->integer(11)->unsigned()->notNull()->defaultValue(0),
            'updated_at' => $this->integer(11)->unsigned()->notNull()->defaultValue(0),
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
