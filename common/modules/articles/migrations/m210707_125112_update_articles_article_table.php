<?php

use yii\db\Migration;
use common\modules\articles\Articles as ParentModule;

class m210707_125112_update_articles_article_table extends Migration
{

    /**
    * @var string
    */
    public $table = '{{%articles_article}}';

    /**
     * @inheritdoc
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
        $this->addColumn($this->table, 'mark', "enum('0','1') NOT NULL DEFAULT '0' COMMENT 'Mark'");
        $this->createIndex('mark', $this->table, 'mark');
    }

    /**
     * Cancel migration
     */
    public function safeDown()
    {
        $this->dropIndex('mark', $this->table);
        $this->dropColumn($this->table, 'mark');
    }
}
