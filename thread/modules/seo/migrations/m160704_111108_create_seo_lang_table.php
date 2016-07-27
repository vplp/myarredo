<?php

use yii\db\Migration;

/**
 * Handles the creation for table `seo_lang_table`.
 */
class m160704_111108_create_seo_lang_table extends Migration
{
    /**
     * Related Page table name
     * @var string
     */
    public $tablePage = '{{%seo}}';

    /**
     * Language Page table name
     * @var string
     */
    public $tablePageLang = '{{%seo_lang}}';

    /**
     * Implement migration
     */
    public function safeUp()
    {
        $this->createTable($this->tablePageLang, [
            'rid' => $this->integer()->unsigned()->notNull()->comment('Related model ID'),
            'lang' => $this->string(5)->notNull()->comment('Language'),
            'title' => $this->string(255)->notNull()->comment('Seo Title'),
            'description' => $this->string(255)->notNull()->comment('Seo Description'),
            'keywords' => $this->string(255)->notNull()->comment('Seo Keywords'),
        ]);

        $this->createIndex('rid', $this->tablePageLang, ['rid', 'lang'], true);

        $this->addForeignKey(
            'fk-seo_lang-rid-seo-id',
            $this->tablePageLang,
            'rid',
            $this->tablePage,
            'id',
            'CASCADE',
            'CASCADE'
        );
    }

    /**
     * Cancel migration
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-seo_lang-rid-seo-id', $this->tablePageLang);
        $this->dropIndex('rid', $this->tablePageLang);
        $this->dropTable($this->tablePageLang);
    }
}
