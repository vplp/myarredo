<?php

use yii\db\Migration;
//
use thread\modules\catalog\Catalog as CatalogModule;

/**
 * Class m161012_111207_create_catalog_group_lang_table
 *
 * @author Andrii Bondarchuk
 * @copyright (c) 2016, VipDesign
 */
class m161012_111207_create_catalog_group_lang_table extends Migration
{
    /**
     * Catalog group table name
     * @var string
     */
    public $tableGroup = '{{%catalog_group}}';

    /**
     * Catalog group language table name
     * @var string
     */
    public $tableGroupLang = '{{%catalog_group_lang}}';

    /**
     *
     */
    public function init()
    {
        $this->db = CatalogModule::getDb();
        parent::init();
    }

    /**
     * Implement migration
     */
    public function safeUp()
    {
        $this->createTable($this->tableGroupLang, [
            'rid' => $this->integer()->unsigned()->notNull()->comment('Related model ID'),
            'lang' => $this->string(5)->notNull()->comment('Language'),
            'title' => $this->string(255)->notNull()->comment('Title')
        ]);

        $this->createIndex('rid', $this->tableGroupLang, ['rid', 'lang'], true);

        $this->addForeignKey(
            'fk-catalog_group_lang-rid-catalog_group-id',
            $this->tableGroupLang,
            'rid',
            $this->tableGroup,
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
        $this->dropForeignKey('fk-catalog_group_lang-rid-catalog_group-id', $this->tableGroupLang);
        $this->dropIndex('rid', $this->tableGroupLang);
        $this->dropTable($this->tableGroupLang);
    }
}