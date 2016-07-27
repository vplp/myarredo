<?php

use yii\db\Migration;
use thread\modules\news\News;

/**
 * Class m160127_030515_create_fv_news_group_table
 *
 * @package thread\modules\news
 * @author Roman Gonchar <roman.gonchar92@gmail.com>
 * @copyright (c) 2016, VipDesign
 */
class m160127_030515_create_fv_news_group_table extends Migration
{
    /**
     * @var string
     */
    public $tableNewsGroup = '{{%news_group}}';

    public function init()
    {
        $this->db = News::getDb();
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
            'created_at' => $this->integer(10)->notNull()->defaultValue(0)->comment('Create time'),
            'updated_at' => $this->integer(10)->notNull()->defaultValue(0)->comment('Update time'),
            'published' => $this->boolean()->notNull()->defaultValue(0)->comment('Published'),
            'deleted' => $this->boolean()->notNull()->defaultValue(0)->comment('Deleted'),
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
