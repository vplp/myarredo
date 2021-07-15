<?php

use yii\db\Migration;
use common\modules\articles\Articles;

/**
 * Handles the creation of table `{{%articles_article_rel_city}}`.
 */
class m210715_154448_create_articles_article_rel_city_table extends Migration
{
    /**
     * @var string
     */
    public $tableRel = '{{%articles_article_rel_city}}';

    /**
     * @var string
     */
    public $tableArticle = '{{%articles_article}}';

    /**
     * @var string
     */
    public $tableCity = '{{%location_city}}';

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
            'city_id' => $this->integer(11)->unsigned()->notNull(),
        ]);

        $this->createIndex('idx_article_id', $this->tableRel, 'article_id');
        $this->createIndex('idx_city_id', $this->tableRel, 'city_id');
        $this->createIndex('idx_article_id_city_id', $this->tableRel, ['article_id', 'city_id'], true);

        $this->addForeignKey(
            'fk-articles_article_rel_city_ibfk_1',
            $this->tableRel,
            'article_id',
            $this->tableArticle,
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-articles_article_rel_city_ibfk_2',
            $this->tableRel,
            'city_id',
            $this->tableCity,
            'id',
            'CASCADE',
            'CASCADE'
        );

        $rows = (new \yii\db\Query())
            ->from($this->tableArticle)
            ->all();

        foreach ($rows as $row) {
            if ($row['city_id']) {
                $connection = Yii::$app->db;
                $connection->createCommand()
                    ->insert(
                        $this->tableRel,
                        [
                            'article_id' => $row['id'],
                            'city_id' => $row['city_id']
                        ]
                    )
                    ->execute();
            }
        }
    }

    /**
     * Cancel migration
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-articles_article_rel_city_ibfk_2', $this->tableRel);
        $this->dropForeignKey('fk-articles_article_rel_city_ibfk_1', $this->tableRel);

        $this->dropIndex('idx_article_id_city_id', $this->tableRel);
        $this->dropIndex('idx_city_id', $this->tableRel);
        $this->dropIndex('idx_article_id', $this->tableRel);

        $this->dropTable($this->tableRel);
    }
}
