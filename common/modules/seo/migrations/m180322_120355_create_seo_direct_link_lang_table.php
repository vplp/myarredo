<?php

use yii\db\Migration;
//
use common\modules\seo\Seo;

/**
 * Class m180322_120355_create_seo_direct_link_lang_table
 */
class m180322_120355_create_seo_direct_link_lang_table extends Migration
{
    /**
     * @var string
     */
    public $table = '{{%seo_direct_link}}';

    /**
     * @var string
     */
    public $tableLang = '{{%seo_direct_link_lang}}';

    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->db = Seo::getDb();
        parent::init();
    }

    /**
     * Implement migration
     */
    public function safeUp()
    {
        $this->createTable($this->tableLang, [
            'rid' => $this->integer(11)->unsigned()->notNull()->comment('Related model ID'),
            'lang' => $this->string(5)->notNull()->comment('Language'),
            'title' => $this->string(255)->notNull()->comment('Title'),
            'description' => $this->string(255)->notNull()->comment('description'),
            'keywords' => $this->string(255)->notNull()->comment('keywords'),
            'h1' => $this->string(128)->notNull()->comment('H1'),
            'content' => $this->text()->defaultValue(null)->comment('Content'),
        ]);

        $this->createIndex('rid', $this->tableLang, ['rid', 'lang'], true);

        $this->addForeignKey(
            'fk-seo_direct_link_lang-rid-seo_direct_link-id',
            $this->tableLang,
            'rid',
            $this->table,
            'id',
            'CASCADE',
            'CASCADE'
        );

        /**
         * Update tableLang
         */

        $rows = (new \yii\db\Query())
            ->from($this->table)
            ->all();

        foreach ($rows as $row) {
            $connection = Yii::$app->db;

            $connection->createCommand()
                ->insert(
                    $this->tableLang,
                    [
                        'rid' => $row['id'],
                        'lang' => 'ru-RU',
                        'title' => $row['title'],
                        'description' => $row['description'],
                        'keywords' => $row['keywords'],
                        'h1' => $row['h1'],
                        'content' => $row['content'],
                    ]
                )
                ->execute();
        }
    }

    /**
     * Cancel migration
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-seo_direct_link_lang-rid-seo_direct_link-id', $this->tableLang);
        $this->dropIndex('rid', $this->tableLang);

        $this->dropTable($this->tableLang);
    }
}
