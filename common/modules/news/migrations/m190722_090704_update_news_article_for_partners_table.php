<?php

use yii\db\Migration;
//
use common\modules\news\News;

class m190722_090704_update_news_article_for_partners_table extends Migration
{
    /**
     * table name
     * @var string
     */
    public $table = '{{%news_article_for_partners}}';

    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->db = News::getDb();
        parent::init();
    }

    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->addColumn(
            $this->table,
            'image_link',
            $this
                ->string(255)
                ->defaultValue(null)
                ->comment('Image link')
                ->after('id')
        );
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->dropColumn($this->table, 'image_link');
    }
}
