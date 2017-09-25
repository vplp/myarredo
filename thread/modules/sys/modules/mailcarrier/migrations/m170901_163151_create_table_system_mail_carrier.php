<?php

use yii\db\Migration;
use thread\modules\sys\modules\mailcarrier\MailCarrier as ParentModule;

/**
 * Class m170901_163151_create_table_system_mail_carrier
 *
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */
class m170901_163151_create_table_system_mail_carrier extends Migration
{

    /**
     * @var string
     */
    public $table = '{{%system_mail_carrier}}';

    /**
     * @var string
     */
    public $tableBox = '{{%system_mail_box}}';

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
            'mailbox_id' => $this->integer()->unsigned()->notNull()->comment('mailbox_id'),
            'alias' => $this->string(32)->notNull()->unique()->comment('Alias'),
            'default_title' => $this->string(255)->notNull()->defaultValue('')->comment('Default title'),
            'path_to_layout' => $this->string(255)->notNull()->defaultValue('')->comment('path_to_layout'),
            'path_to_view' => $this->string(255)->notNull()->defaultValue('')->comment('path_to_view'),
            'from_user' => $this->string(255)->notNull()->defaultValue('')->comment('from_user'),
            'from_email' => $this->string(255)->notNull()->comment('from_email'),
            'subject' => $this->string(4096)->notNull()->defaultValue('')->comment('subject'),
            'send_to' => $this->string(255)->notNull()->comment('send_to'),
            'send_cc' => $this->string(4096)->notNull()->defaultValue('')->comment('send_cc'),
            'send_bcc' => $this->string(4096)->notNull()->defaultValue('')->comment('send_bcc'),
            'created_at' => $this->integer()->unsigned()->notNull()->defaultValue(0)->comment('Create time'),
            'updated_at' => $this->integer()->unsigned()->notNull()->defaultValue(0)->comment('Update time'),
            'published' => "enum('0','1') NOT NULL DEFAULT '0' COMMENT 'Published'",
            'deleted' => "enum('0','1') NOT NULL DEFAULT '0' COMMENT 'Deleted'",
        ]);
        //
        $this->createIndex('published', $this->table, 'published');
        $this->createIndex('deleted', $this->table, 'deleted');
        //
        $this->createIndex('mailbox_id', $this->table, 'mailbox_id');
        //
        $this->addForeignKey(
            'fv_system_mail_carrier_ibfk_1',
            $this->table,
            'mailbox_id',
            $this->tableBox,
            'id',
            'RESTRICT',
            'CASCADE'
        );
    }

    /**
     * Cancel migration
     */
    public function safeDown()
    {
        $this->dropForeignKey('fv_system_mail_carrier_ibfk_1', $this->tableLang);
        $this->dropIndex('deleted', $this->table);
        $this->dropIndex('published', $this->table);
        //
        $this->dropIndex('mailbox_id', $this->table);
        //
        $this->dropTable($this->table);
    }
}
