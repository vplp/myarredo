<?php

use yii\db\Migration;
use common\modules\news\News as ParentModule;

class m211101_111209_update_news_article_table extends Migration
{

    /**
     * @var string
     */
    public $table = '{{%news_article}}';

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
        $this->addColumn(
            $this->table,
            'gallery_image',
            $this
                ->string(1024)
                ->defaultValue(null)
                ->comment('Gallery image')
                ->after('image_link')
        );
    }

    /**
     * Cancel migration
     */
    public function safeDown()
    {
        $this->dropColumn($this->table, 'gallery_image');
    }
}
