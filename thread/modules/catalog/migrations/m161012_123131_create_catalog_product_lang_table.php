<?php

use yii\db\Migration;
//
use thread\modules\catalog\Catalog as CatalogModule;

/**
 * Class m161012_123131_create_catalog_product_lang_table
 *
 * @author Andrii Bondarchuk
 * @copyright (c) 2016, VipDesign
 */
class m161012_123131_create_catalog_product_lang_table extends Migration
{
    /**
     * Catalog product table name
     * @var string
     */
    public $tableProduct = '{{%catalog_product}}';

    /**
     * Catalog product language table name
     * @var string
     */
    public $tableProductLang = '{{%catalog_product_lang}}';

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
        $this->createTable(
            $this->tableProductLang,
            [
                'rid' => $this->integer()->unsigned()->notNull()->comment('Related model ID'),
                'lang' => $this->string(5)->notNull()->comment('Language'),
                'title' => $this->string(255)->notNull()->comment('Title'),
                'description' => $this->string(1024)->defaultValue(null)->comment('Description'),
                'content' => $this->text()->defaultValue(null)->comment('Content'),
            ]
        );

        $this->createIndex('rid', $this->tableProductLang, ['rid', 'lang'], true);

        $this->addForeignKey(
            'fk-catalog_product_lang-rid-catalog_product-id',
            $this->tableProductLang,
            'rid',
            $this->tableProduct,
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
        $this->dropForeignKey('fk-catalog_product_lang-rid-catalog_product-id', $this->tableProductLang);
        $this->dropIndex('rid', $this->tableProductLang);
        $this->dropTable($this->tableProductLang);
    }
}
