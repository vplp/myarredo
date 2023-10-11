<?php

use yii\db\Migration;
//
use common\modules\articles\Articles;

/**
 * Handles the creation of table `{{%articles_article_rel_catalog_type}}`.
 */
class m190307_160448_create_articles_article_rel_catalog_type_table extends Migration
{
    /**
     * @var string
     */
    public $tableRel = '{{%articles_article_rel_catalog_type}}';

    /**
     * @var string
     */
    public $tableArticle = '{{%articles_article}}';

    /**
     * @var string
     */
    public $tableType = '{{%catalog_type}}';

    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->db = Articles::getDb();
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
