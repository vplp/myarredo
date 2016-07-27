<?php

use yii\db\Migration;

class m160722_130448_add_column_gallery_to_article extends Migration
{

    /**
     * @var string
     */
    public $tableNewsArticle = '{{%news_article}}';

    public function safeUp()
    {
        $this->addColumn($this->tableNewsArticle, 'gallery_link', $this->text()->defaultValue(null)->comment('Gallery'));
    }

    public function safeDown()
    {
        $this->dropColumn($this->tableNewsArticle, 'gallery_link');
    }
}
