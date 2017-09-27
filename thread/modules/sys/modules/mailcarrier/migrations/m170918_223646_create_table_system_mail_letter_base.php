<?php

use yii\db\Migration;
use thread\modules\sys\modules\mailcarrier\MailCarrier as ParentModule;

/**
 * Class m170918_223646_create_table_system_mail_letter_base
 *
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */
class m170918_223646_create_table_system_mail_letter_base extends Migration
{

    /**
     * @var string
     */
    public $table = '{{%system_mail_letter_base}}';

    /**
     *
     */
    public function init()
    {
        $this->db = ParentModule::getDb();
        parent::init();
    }

    /**
     * Implement migration
     */
    public function safeUp()
    {
        $this->createTable($this->table, [
            'id' => $this->primaryKey()->unsigned()->comment('ID'),
            'carrier' => $this->string(255)->notNull()->comment('carrier'),
            'letter' => "longtext NOT NULL COMMENT 'letter'",
            'created_at' => $this->integer()->unsigned()->notNull()->defaultValue(0)->comment('Create time'),
            'updated_at' => $this->integer()->unsigned()->notNull()->defaultValue(0)->comment('Update time'),
            'published' => "enum('0','1') NOT NULL DEFAULT '0' COMMENT 'Published'",
            'deleted' => "enum('0','1') NOT NULL DEFAULT '0' COMMENT 'Deleted'",
        ]);

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

        $this->dropTable($this->table);
    }
}
