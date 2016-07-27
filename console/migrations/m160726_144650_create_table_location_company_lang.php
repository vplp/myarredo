<?php

use yii\db\Migration;

class m160726_144650_create_table_location_company_lang extends Migration
{
    /**
     * Related Page table name
     *
     * @var string
     */
    public $tablePage = '{{%location_company}}';

    /**
     * Language Page table name
     *
     * @var string
     */
    public $tablePageLang = '{{%location_company_lang}}';

    /**
     * Implement migration
     */
    public function safeUp()
    {
        $this->createTable($this->tablePageLang, [
            'rid' => $this->integer()->unsigned()->notNull()->comment('Related model ID'),
            'lang' => $this->string(5)->notNull()->comment('Language'),
            'title' => $this->string(255)->unsigned()->notNull()->comment('Название улицы'),
            'street' => $this->string(255)->unsigned()->notNull()->comment('Название улицы'),
            'house' => $this->string(255)->unsigned()->notNull()->comment('Дом')
        ]);

        $this->createIndex('rid', $this->tablePageLang, ['rid', 'lang'], true);

        $this->addForeignKey(
            'fk-location_company_lang-rid-location_company-id',
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
        $this->dropForeignKey('fk-location_company_lang-rid-location_company-id', $this->tablePageLang);
        $this->dropIndex('rid', $this->tablePageLang);
        $this->dropTable($this->tablePageLang);
    }
}
