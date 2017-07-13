<?php

use yii\db\Migration;

/**
 * Class m160705_094016_create_table_country_lang
 *
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */
class m160705_094016_create_table_country_lang extends Migration
{
    /**
     * Related Page table name
     *
     * @var string
     */
    public $tablePage = '{{%location_country}}';

    /**
     * Language Page table name
     *
     * @var string
     */
    public $tablePageLang = '{{%location_country_lang}}';

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
            'fk-location_country_lang-rid-location_country-id',
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
        $this->dropForeignKey('fk-location_country_lang-rid-location_country-id', $this->tablePageLang);
        $this->dropIndex('rid', $this->tablePageLang);
        $this->dropTable($this->tablePageLang);
    }
}
