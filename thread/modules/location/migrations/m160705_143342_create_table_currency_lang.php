<?php

use yii\db\Migration;

/**
 * Handles the creation for table `table_currency_lang`.
 */
class m160705_143342_create_table_currency_lang extends Migration
{
    /**
     * Related Page table name
     *
     * @var string
     */
    public $tablePage = '{{%location_currency}}';

    /**
     * Language Page table name
     *
     * @var string
     */
    public $tablePageLang = '{{%location_currency_lang}}';

    /**
     * Implement migration
     */
    public function safeUp()
    {
        $this->createTable($this->tablePageLang, [
            'rid' => $this->integer()->unsigned()->notNull()->comment('Related model ID'),
            'lang' => $this->string(5)->notNull()->comment('Language'),
            'title' => $this->string(255)->notNull()->comment('Title')
        ]);

        $this->createIndex('rid', $this->tablePageLang, ['rid', 'lang'], true);

        $this->addForeignKey(
            'fk-location_currency_lang-rid-location_currency-id',
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
        $this->dropForeignKey('fk-location_currency_lang-rid-location_currency-id', $this->tablePageLang);
        $this->dropIndex('rid', $this->tablePageLang);
        $this->dropTable($this->tablePageLang);
    }

}
