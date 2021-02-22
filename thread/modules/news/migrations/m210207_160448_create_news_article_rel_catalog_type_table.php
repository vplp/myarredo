<?php

use yii\db\Migration;
use thread\modules\news\News as ParentModule;

/**
 * Class m210207_160448_create_news_article_rel_catalog_type_table
 */
class m210207_160448_create_news_article_rel_catalog_type_table extends Migration
{
    /**
     * @var string
     */
    public $tableRel = '{{%news_article_rel_catalog_type}}';

    /**
     * @var string
     */
    public $tableArticle = '{{%news_article}}';

    /**
     * @var string
     */
    public $tableType = '{{%catalog_type}}';

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
        $this->createTable($this->tableRel, [
            'article_id' => $this->integer(11)->unsigned()->notNull(),
            'type_id' => $this->integer(11)->unsigned()->notNull(),
        ]);

        $this->createIndex('idx_article_id', $this->tableRel, 'article_id');
        $this->createIndex('idx_type_id', $this->tableRel, 'type_id');
        $this->createIndex('idx_article_id_type_id', $this->tableRel, ['article_id', 'type_id'], true);

//        $this->addForeignKey(
//            'fk-articles_article_rel_catalog_type_ibfk_1',
//            $this->tableRel,
//            'article_id',
//            $this->tableArticle,
//            'id',
//            'CASCADE',
//            'CASCADE'
//        );
//
//        $this->addForeignKey(
//            'fk-articles_article_rel_catalog_type_ibfk_2',
//            $this->tableRel,
//            'type_id',
//            $this->tableType,
//            'id',
//            'CASCADE',
//            'CASCADE'
//        );
    }

    /**
     * Cancel migration
     */
    public function safeDown()
    {
//        $this->dropForeignKey('fk-articles_article_rel_catalog_type_ibfk_2', $this->tableRel);
//        $this->dropForeignKey('fk-articles_article_rel_catalog_type_ibfk_1', $this->tableRel);

        $this->dropIndex('idx_article_id_type_id', $this->tableRel);
        $this->dropIndex('idx_type_id', $this->tableRel);
        $this->dropIndex('idx_article_id', $this->tableRel);

        $this->dropTable($this->tableRel);
    }
}
