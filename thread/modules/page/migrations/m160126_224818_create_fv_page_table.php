<?php

use yii\db\Migration;
use thread\modules\page\Page;

/**
 * Class m160126_224818_create_fv_page_table
 *
 * @package thread\modules\page
 * @author Roman Gonchar <roman.gonchar92@gmail.com>
 * @copyright (c) 2016, VipDesign
 */

class m160126_224818_create_fv_page_table extends Migration
{

    /**
     * Page table name
     * @var string
     */
    public $tablePage = '{{%page}}';

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
            'published' => $this->boolean()->notNull()->defaultValue(0)->comment('Published'),
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
