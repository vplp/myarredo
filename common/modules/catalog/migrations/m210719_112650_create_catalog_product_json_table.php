<?php

use yii\db\Migration;
use common\modules\catalog\Catalog as ParentModule;

/**
 * Handles the creation of table `{{%catalog_item_json}}`.
 */
class m210719_112650_create_catalog_product_json_table extends Migration
{
    /**
     * @var string
     */
    public $table = '{{%catalog_item_json}}';

    public $tableProduct = '{{%catalog_item}}';
    
    /**
     *
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
        $this->createTable($this->table, [
            'rid' => $this->integer()->unsigned()->notNull()->comment('Related model ID'),
            'lang' => $this->string(5)->notNull()->comment('Language'),
            'content' => $this->text(),
        ]);

        $this->createIndex('rid', $this->table, ['rid', 'lang'], true);

        $this->addForeignKey(
            'fk-catalog_item_json-rid-catalog_item-id',
            $this->table,
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
        $this->dropForeignKey('fk-catalog_item_json-rid-catalog_item-id', $this->table);
        $this->dropIndex('rid', $this->table);
        $this->dropTable($this->table);
    }
}
