<?php

use yii\db\Migration;
use thread\modules\correspondence\Сorrespondence;

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
    public $tableСorrespondence = '{{%correspondence}}';

    /**
     *
     */
    public function init()
    {
        $this->db = Сorrespondence::getDb();
        parent::init();
    }

    /**
     * Implement migration
     */
    public function safeUp()
    {
        $this->createTable($this->tableNewsGroup, [
            'id' => $this->primaryKey()->unsigned()->comment('ID'),
            'alias' => $this->string(255)->notNull()->unique()->comment('Alias'),
            'created_at' => $this->integer()->unsigned()->notNull()->defaultValue(0)->comment('Create time'),
            'updated_at' => $this->integer()->unsigned()->notNull()->defaultValue(0)->comment('Update time'),
            'published' => "enum('0','1') NOT NULL DEFAULT '0' COMMENT 'Published'",
            'deleted' => "enum('0','1') NOT NULL DEFAULT '0' COMMENT 'Deleted'",
        ]);

        $this->createIndex('published', $this->tableNewsGroup, 'published');
        $this->createIndex('deleted', $this->tableNewsGroup, 'deleted');
    }

    /**
     * Cancel migration
     */
    public function safeDown()
    {
        $this->dropIndex('deleted', $this->tableNewsGroup);
        $this->dropIndex('published', $this->tableNewsGroup);
        $this->dropTable($this->tableNewsGroup);
    }
}
