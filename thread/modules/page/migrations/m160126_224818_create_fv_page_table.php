<?php

use yii\db\Migration;
use thread\modules\page\Page;

/**
 * Class m160126_224818_create_fv_page_table
 *
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */
class m160126_224818_create_fv_page_table extends Migration
{

    /**
     * Page table name
     * @var string
     */
    public $tablePage = '{{%page}}';

    /**
     *
     */
    public function init()
    {
        $this->db = Page::getDb();
        parent::init();
    }

    /**
     * Implement migration
     */
    public function safeUp()
    {
        $this->createTable($this->tablePage, [
            'id' => $this->primaryKey()->unsigned()->comment('ID'),
            'alias' => $this->string(255)->notNull()->unique()->comment('alias'),
            'image_link' => $this->string(255)->defaultValue(null)->comment('Image link'),
            'created_at' => $this->integer()->unsigned()->notNull()->defaultValue(0)->comment('Create time'),
            'updated_at' => $this->integer()->unsigned()->notNull()->defaultValue(0)->comment('Update time'),
            'published' => "enum('0','1') NOT NULL DEFAULT '0' COMMENT 'Published'",
            'deleted' => $this->boolean()->notNull()->defaultValue(0)->comment('Deleted')
        ]);

        $this->createIndex('published', $this->tablePage, 'published');
        $this->createIndex('deleted', $this->tablePage, 'deleted');
    }

    /**
     * Cancel migration
     */
    public function safeDown()
    {
        $this->dropIndex('deleted', $this->tablePage);
        $this->dropIndex('published', $this->tablePage);
        $this->dropTable($this->tablePage);
    }
}
