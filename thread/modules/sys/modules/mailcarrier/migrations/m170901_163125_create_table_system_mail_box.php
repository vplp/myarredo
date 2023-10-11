<?php

use yii\db\Migration;
use thread\modules\sys\modules\mailcarrier\MailCarrier as ParentModule;

/**
 * Class m170901_163125_create_table_system_mail_box
 *
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */
class m170901_163125_create_table_system_mail_box extends Migration
{

    /**
     * @var string
     */
    public $table = '{{%system_mail_box}}';

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
            'alias' => $this->string(32)->notNull()->unique()->comment('Alias'),
            'default_title' => $this->string(255)->notNull()->defaultValue('')->comment('Default title'),
            'host' => $this->string(255)->notNull()->comment('Host'),
            'username' => $this->string(255)->notNull()->comment('Username'),
            'password' => $this->string(255)->notNull()->comment('Password'),
            'port' => $this->integer()->unsigned()->notNull()->defaultValue(25)->comment('port'),
            'encryption' => "enum('','tls','ssl') NOT NULL DEFAULT '' COMMENT 'Encryption'",
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
