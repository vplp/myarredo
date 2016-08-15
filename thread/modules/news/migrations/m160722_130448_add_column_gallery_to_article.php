<?php

use yii\db\Migration;
use thread\modules\news\News;

/**
 * Class m160722_130448_add_column_gallery_to_article
 *
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */
class m160722_130448_add_column_gallery_to_article extends Migration
{

    /**
     * @var string
     */
    public $tableNewsArticle = '{{%news_article}}';

    /**
     *
     */
    public function init()
    {
        $this->db = News::getDb();
        parent::init();
    }

    /**
     *
     */
    public function safeUp()
    {
        $this->addColumn($this->tableNewsArticle, 'gallery_link', $this->text()->defaultValue(null)->comment('Gallery'));
    }

    /**
     *
     */
    public function safeDown()
    {
        $this->dropColumn($this->tableNewsArticle, 'gallery_link');
    }
}
