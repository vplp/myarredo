<?php

use yii\db\Migration;
use thread\modules\correspondence\Correspondence;

/**
 * Class m160904_030515_create_fv_correspondence_table
 *
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */
class m160904_030515_create_fv_correspondence_table extends Migration
{
    /**
     * @var string
     */
    public $tableCorrespondence = '{{%correspondence}}';

    /**
     *
     */
    public function init()
    {
        $this->db = Correspondence::getDb();
        parent::init();
    }

    /**
     * Implement migration
     */
    public function safeUp()
    {
        $this->createTable($this->tableCorrespondence, [
            'id' => $this->primaryKey()->unsigned()->comment('ID'),
            'sender_id' => $this->integer()->unsigned()->notNull()->comment('Sender'),
            'recipient_id' => $this->integer()->unsigned()->notNull()->comment('Recipient'),
            'subject' => $this->string(512)->notNull()->comment('Subject'),
            'message' => $this->text()->notNull()->comment('Message'),
            'created_at' => $this->integer()->unsigned()->notNull()->defaultValue(0)->comment('Create time'),
            'updated_at' => $this->integer()->unsigned()->notNull()->defaultValue(0)->comment('Update time'),
            'is_read' => "enum('0','1') NOT NULL DEFAULT '0' COMMENT 'Is read'",
            'published' => "enum('0','1') NOT NULL DEFAULT '0' COMMENT 'Published'",
            'deleted' => "enum('0','1') NOT NULL DEFAULT '0' COMMENT 'Deleted'",
        ]);

        $this->createIndex('sender_id', $this->tableCorrespondence, 'sender_id');
        $this->createIndex('recipient_id', $this->tableCorrespondence, 'recipient_id');
        $this->createIndex('is_read', $this->tableCorrespondence, 'is_read');
        $this->createIndex('published', $this->tableCorrespondence, 'published');
        $this->createIndex('deleted', $this->tableCorrespondence, 'deleted');
    }

    /**
     * Cancel migration
     */
    public function safeDown()
    {
        $this->dropIndex('sender_id', $this->tableCorrespondence);
        $this->dropIndex('recipient_id', $this->tableCorrespondence);
        $this->dropIndex('is_read', $this->tableCorrespondence);
        $this->dropIndex('deleted', $this->tableCorrespondence);
        $this->dropIndex('published', $this->tableCorrespondence);
        $this->dropTable($this->tableCorrespondence);
    }
}
