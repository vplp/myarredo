<?php

use yii\db\Migration;
//
use common\modules\seo\Seo as SeoModule;

/**
 * Handles the creation of table `seo_redirects`.
 */
class m180417_122248_create_seo_redirects_table extends Migration
{
    /**
     * @var string
     */
    public $table = '{{%seo_redirects}}';
    
    /**
     * @throws \yii\base\InvalidConfigException
     */
    public function init()
    {
        $this->db = SeoModule::getDb();
        parent::init();
    }

    /**
     * @return bool|void
     */
    public function safeUp()
    {
        $this->createTable($this->table, [
            'id' => $this->primaryKey()->unsigned()->comment('ID'),
            'url_from' => $this->string(512)->notNull(),
            'url_to' => $this->string(512)->notNull(),
            'created_at' => $this->integer(11)->unsigned()->notNull()->defaultValue(0)->comment('Create time'),
            'updated_at' => $this->integer(11)->unsigned()->notNull()->defaultValue(0)->comment('Update time'),
            'published' => "enum('0','1') NOT NULL DEFAULT '0' COMMENT 'Published'",
            'deleted' => "enum('0','1') NOT NULL DEFAULT '0' COMMENT 'Deleted'",
        ]);
        
        $this->createIndex('published', $this->table, 'published');
        $this->createIndex('deleted', $this->table, 'deleted');
    }

    /**
     * @return bool|void
     */
    public function safeDown()
    {
        $this->dropIndex('deleted', $this->table);
        $this->dropIndex('published', $this->table);

        $this->dropTable($this->table);
    }
}
